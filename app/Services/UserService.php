<?php

namespace App\Services;

use App\Events\SendInfoEvent;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Str;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    private const AVATAR_HEIGHT = 200;
    private const AVATAR_WIDTH = 200;

    public function __construct(public UserRepository $userRepository)
    {
    }

    public function getPaginated(array $params = []): array
    {
        return [
            'list' => UserResource::collection($this->userRepository->getPaginated($params)),
            'count' => $this->userRepository->count($params),
        ];
    }

    public function update(User $user, array $data): array
    {
        if ($user->id != auth()->id() && auth()->user()->role != User::ROLE_ADMIN) {
            throw new Exception(__('errors.accessDenied'), Response::HTTP_FORBIDDEN);
        }

        if (isset($data['image']) && !is_null($user->image)) {
            ImageService::deleteFromStorage($user->image);
        }

        if (isset($data['image'])) {
            $data['image'] = ImageService::uploadImage($data['image']);
        }

        $user->update($data);

        return [
            'message' => __('messages.updateUser'),
            'user' => new UserResource($user),
        ];
    }

    public function create(array $data): array
    {
        $password = Str::random(10);

        event(new SendInfoEvent($data['email'], $password));

        $data = array_merge($data, [
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt($password),
        ]);

        $user = $this->userRepository->create($data);

        return [
            'message' => __('messages.createUser'),
            'user' => new UserResource($user)
        ];
    }

    public function delete(User $user): void
    {
        $user->devices()->delete();
        $user->courierApplication()->delete();
        $user->addresses()->delete();
        $user->refreshToken()->delete();
        $user->email = $user->email . '_' . time();
        $user->save();
        $user->delete();
    }

    public function changePassword(string $oldPassword, $newPassword): array
    {
        $user = auth()->user();
        if (!Hash::check($oldPassword, $user->password)) {
            throw new Exception(__('passwords.wrongPassword'), Response::HTTP_BAD_REQUEST);
        }

        $user->password = bcrypt($newPassword);
        $user->save();

        return [
            'message' => __('passwords.passwordChanged'),
            'token' => auth()->login($user),
        ];
    }
}
