<?php

namespace App\Actions\Common;

use App\Models\Attachment;
use App\Traits\FileSizeTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class CreateAttachmentAction
{
    use FileSizeTrait;

    /**
     * @param $relation
     * @param $request
     * @param $user
     * @param $type
     * @return void
     */
    public function execute($relation, $request, $user, $type): void
    {
        foreach ($request->file() as $key => $file) {
            $order = $request[$key . '_index'];

            $attachment = Attachment::query()->where('attachmentable_id', $relation->uid)
                ->where('order', $order)->first();

            if ($attachment) {
                Storage::disk('public')->delete($attachment->url);
            }

            $randomString = Str::random(4);
            $fileName = 'attachment_' . time() . '_' . $randomString . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put($type . '/' . $fileName, file_get_contents($file->getRealPath()));

            $attachment_data = [
                'uid' => Uuid::uuid4()->toString(),
                'name' => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'size' => $this->formatBytes($file->getSize()),
                'type' => $file->getMimeType(),
                'url' => 'storage/' . $type . '/' . $fileName,
                'order' => (int)$order,
                'user_id' => $user->uid,
            ];


            if ($attachment) {
                $attachment->update($attachment_data);
            } else {
                $relation->attachments()->create($attachment_data);
            }
        }
    }
}
