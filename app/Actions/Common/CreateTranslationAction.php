<?php

namespace App\Actions\Common;

use App\Models\Translation;
use Ramsey\Uuid\Uuid;

class CreateTranslationAction
{

    /**
     * @param $relation
     * @param $request
     * @param $user
     * @return void
     */
    public function execute($relation, $request, $user): void
    {
        $locale = ['ne', 'en'];

        foreach ($locale as $lan) {
            foreach ($request as $items) {
                foreach ($items as $key => $item) {
                    $translate = Translation::query()
                        ->where('translationable_id', $relation->uid)
                        ->where('locale', $lan)
                        ->where('title', $key)
                        ->first();

                    if ($translate) {
                        $translate->update([
                            'description' => $item,
                        ]);
                    } else {
                        $relation->translations()->create([
                            'uid' => Uuid::uuid4()->toString(),
                            'locale' => $lan,
                            'title' => $key,
                            'description' => $item,
                            'user_id' => $user->uid,
                        ]);
                    }
                }
            }
        }
    }
}
