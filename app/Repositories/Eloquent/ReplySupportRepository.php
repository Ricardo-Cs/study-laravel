<?php

namespace App\Repositories\Eloquent;

use App\DTO\Replies\CreateReplyDTO;
use App\Models\ReplySupport;
use App\Repositories\Contracts\ReplyRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use stdClass;

class ReplySupportRepository implements ReplyRepositoryInterface {

    public function __construct(protected ReplySupport $model) {
    }

    public function getAllBySupportId(string $supportId): array {
        $replies = $this->model->with('user', 'support')->where('support_id', $supportId)->get();

        return $replies->toArray();
    }

    public function createNew(CreateReplyDTO $dto): stdClass {
        $reply = $this->model->create([
            'support_id' => $dto->supportId,
            'content' => $dto->content,
            'user_id' => Auth::user()->id,
        ]);

        return (object) $reply->toArray();
    }
}
