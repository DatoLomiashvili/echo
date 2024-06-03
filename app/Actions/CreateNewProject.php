<?php

namespace App\Actions;

use App\Events\UserRegistered;
use App\Models\Project;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewProject
{
    use AsAction;

    public function __construct(){
    }
    public string $commandSignature = 'projects:create {user_id} {title}';
    public string $commandDescription = 'Create a new project with user id and title';

    /**
     * @param User $user
     * @param string $title
     * @return Project
     */
    public function handle(User $user, string $title): Project
    {
        $data =
            [
                'title' => $user->name . ' - ' . $title,
            ];
        return Project::create($data);
    }


    /**
     * @param Command $command
     * @return void
     */
    public function asCommand(Command $command): void
    {
        $this->handle(
            User::findOrFail($command->argument('user_id')),
            $command->argument('title')
        );
        $command->info('Done!');
    }

    /**
     * @return array[]
     */
    public function rules() : array
    {
        return [
            'title' => ['required', 'string'],
            'user_id' => ['required', 'exists:users']
        ];
    }

    /**
     * @param Request $request
     * @return Project
     */
    public function asController(Request $request): Project
    {
        $projectTitle = $request->get('title');
        return $this->handle($request->user(), $projectTitle);
    }

    /**
     * @param UserRegistered $event
     * @return void
     */
    public function asListener(UserRegistered $event): void
    {
        $this->handle($event->user, 'proeqtebi');
    }

    /**
     * @param $userId
     * @param $title
     * @return void
     */
    public function asJob($userId, $title): void
    {
        $user = User::findOrFail($userId);
        $this->handle($user, $title);
    }
}
