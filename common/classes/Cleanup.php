<?php

namespace app\common\classes;

use app\models\Board;
use app\models\Thread;
use app\models\Post;
use app\models\PostData;
use app\models\PostMessage;


class Cleanup
{
    
    private static function getPostDataIds(Array &$carry)
    {

        /**
         * Find postDataIds owned by threads and posts (which owned by threads)
         */
        foreach (Thread::findAll($carry['threadsIds']) as $thread) {
            $carry['postDataIds'][] = $thread->postDataId;
            
            foreach ($thread->posts as $post) {
                $carry['postDataIds'][] = $post->postData->id;
            }
        }

        /**
         * Find postDataIds owned by posts
         */
        foreach (Post::findAll($carry['postsIds']) as $post) {
            $carry['postDataIds'][] = $post->postDataId;
        }
    }
    
    private static function getPostMessageIds(Array &$carry)
    {
        foreach (PostData::findAll($carry['postDataIds']) as $postData) {
            $carry['postMessageIds'][] = $postData->messageId;
        }

    }

    /**
     * TODO: In future models will have more relations which might not delete automatically. It should be tested properly
     * Deletes all boards, threads and posts with 'is_deleted = 1', handles relation between them.
     * @return array with deleted rows
     */
    
    public static function clean()
    {
        $itemsToDelete = [
            'boardsIds' => [],
            'threadsIds' => [],
            'postsIds' => [],
            'postDataIds' => [],
            'postMessageIds' => []
        ];
        
        (new Post())->getDeletedRows($itemsToDelete);
        (new Thread())->getDeletedRows($itemsToDelete);
        (new Board())->getDeletedRows($itemsToDelete);
        self::getPostDataIds($itemsToDelete);
        self::getPostMessageIds($itemsToDelete);

        /**
         * Deletes post_message's related to threads and posts
         */
        $deleted['post_messages'] = PostMessage::deleteAll(['in', 'id', array_unique($itemsToDelete['postMessageIds'])]);

        /**
         * Deletes threads and posts because of FK
         */
        $deleted['threads'] = Thread::deleteAll(['in', 'id', array_unique($itemsToDelete['threadsIds'])]);

        /**
         * Deleted posts and threads related to post_data
         */
        $deleted['post_data'] = PostData::deleteAll(['in', 'id', array_unique($itemsToDelete['postDataIds'])]);

        /**
         * Deleted boards
         */
        $deleted['boards'] = Board::deleteAll(['in', 'id', array_unique($itemsToDelete['boardsIds'])]);


        $deleted['posts'] = $deleted['post_data'] - $deleted['threads'];
        $deleted['total'] =
            $deleted['boards'] + $deleted['threads'] +
            $deleted['posts'] + $deleted['post_data'] +
            $deleted['post_messages'];

        return $deleted;
    }
}