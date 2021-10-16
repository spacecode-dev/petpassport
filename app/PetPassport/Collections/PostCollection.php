<?php

namespace App\PetPassport\Collections;

use Illuminate\Database\Eloquent\Collection;
use App\PetPassport\Models\Post;
use App\PetPassport\Models\Like;

class PostCollection extends Collection
{

    /**
     * @param $post
     */
    private function sanitizeOwner($post)
    {
        if ($post->owner_type == 'profile') {
            $post->owner->setVisible([
                //'type',
                //'slug',
                'name',
                'verified',
                'link',
                'avatar'
            ]);
        }
        if ($post->owner_type == 'community') {
            $post->owner->setVisible([
                //'type',
                //'slug',
                'name',
                'verified',
                'link',
                'avatar'
            ]);
        }
    }

    /**
     * @param $attachments
     */
    private function sanitizeAttachments($attachments)
    {
        $attachments->map(function ($attachment) {
            if ($attachment->attachment_type === 'announcement') {
                $attachment->attachment->setVisible([
                    'path',
                    'title',
                    'description',
                    'price',
                    'currency',
                    'photo'
                ]);
                if ($attachment->attachment->photo) {
                    $attachment->attachment->photo->setVisible([
                        'path',
                        'thumb_largest'
                    ]);
                }
            }
        });
    }

    /**
     * @param $post
     */
    private function sanitizePost($post)
    {
        $this->sanitizeOwner($post);
        $this->sanitizeAttachments($post->attachments);
    }

    public function sanitize()
    {
        $this->map(function ($post) {
            $this->sanitizePost($post);
            if ($post->origin) {
                $this->sanitizePost($post->origin);
            }
        });
    }

    /*
    public function originsQuery()
    {
        $ids = $this->pluck('origin_id')->filter()->unique();

        return Post::whereIn('id', $ids);
    }

    public function origins()
    {
        return $this->originsQuery()->get();
    }

    public function users()
    {
        $postsByOwnerType = $this->groupBy('owner_type');

        $users = [];

        foreach ($postsByOwnerType as $ownerType => $posts) {
            $ownerIds = $posts->groupBy('owner_id')->keys()->toArray();

            if ($ownerType == 'profile') {
                $users = UserProfile::whereIn('user_id', $ownerIds)->get();//->keyBy('user_id');
            }
        }

        return $users;
    }
    */

    /*
    public function liked()
    {
        $user_id = auth('api')->id();

        $ids = $this->pluck('id')->toArray();

        $liked = [];

        if (count($ids)) {
            $liked = PostLike::whereIn('post_id', $ids)
                             ->where('user_id', $user_id)
                             ->get()
                             ->pluck('post_id')
                             ->toArray();
        }

        return $liked;
    }

    public function reposted()
    {
        $user_id = auth('api')->id();

        $ids = $this->pluck('id')->toArray();

        $reposted = [];

        if (count($ids)) {
            $reposted = Post::whereIn('origin_id', $ids)
                            ->where('owner_id', $user_id)
                            ->where('owner_type', 'profile')
                            ->get()
                            ->pluck('origin_id')
                            ->toArray();
        }

        return $reposted;
    }
    */

    public function attachFlags()
    {
        $user_id = auth('api')->id();
        $ids = $this->pluck('id')->toArray();
        if (count($ids)) {
            $liked = Like::whereIn('object_id', $ids)
                ->where('object_type', 'post')
                ->where('user_id', $user_id)
                //->select('post_id')
                ->get()
                ->pluck('object_id')
                ->toArray();
            $reposted = Post::whereIn('origin_id', $ids)
                ->where('owner_id', $user_id)
                ->where('owner_type', 'profile')
                //->select('origin_id')
                ->get()
                ->pluck('origin_id')
                ->toArray();
            //dd($user_id);
            $this->map(function ($post) use ($liked, $reposted) {
                $post->liked = in_array($post->id, $liked);
                $post->reposted = in_array($post->id, $reposted);
            });
        }
    }

    /*
    public function loadAttachments()
    {
        $ids = $this->pluck('id')->toArray();

        if (count($ids)) {
            $attachments = PostAttachment::whereIn('post_id', $ids)->get();
            $types = $attachments->groupBy('attachment_type')->keys();

            if ($types->contains('photo')) {
                $this->load('photos');
            }

            if ($types->contains('announcement')) {
                $this->load('announcements');
            }
        }
    }

    public function getAttachments()
    {

    }
    */
}
