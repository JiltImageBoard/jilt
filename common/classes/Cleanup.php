<?php

namespace app\common\classes;

use app\models\Board;
use app\models\Thread;
use app\models\Post;
use app\models\PostData;
use app\models\PostMessage;


class Cleanup
{
    /**
     * TODO: In future models will have more relations which might not delete automatically. It should be tested properly
     * Deletes all boards, threads and posts with 'is_deleted = 1'
     * @return array with deleted rows
     */
    public static function clean()
    {
        $deleted = [];
        $ids = [];

        /**
         * Deletes boards with all relations
         */
        foreach (Board::findAll(['is_deleted' => '1']) as $board) {
            foreach ($board->threads as $thread) {
                foreach ($thread->posts as $post) {
                }
            }
        }

        foreach (Thread::findAll(['is_deleted' => '1']) as $thread) {
            $ids['post_data_ids'][] = $thread->postDataId;

            /**
             * In case thread have is_deleted = 1 and child posts have is_deleted = 0
             */
            foreach ($thread->posts as $post) {
                $ids['posts_ids'][] = $post->id;
                $ids['post_data_ids'][] = $post->postData->id;
            }
        }
        
        foreach (Post::findAll(['is_deleted' => '1']) as $post) {
            $ids['post_data_ids'][] = $post->postDataId;
        }

        foreach (PostData::findAll($ids['post_data_ids']) as $postData) {
            $ids['post_message_ids'][] = $postData->messageId;
        }


        /**
         * Deletes post_message's related to threads and posts
         */
        $deleted['post_messages'] = PostMessage::deleteAll(['in', 'id', $ids['post_message_ids']]);
        
        /**
         * Deletes threads and posts because of FK
         */
        $deleted['threads'] = Thread::deleteAll('is_deleted = 1');

        /**
         * Deletes post_data related to threads and posts
         */
        $deleted['post_data'] = PostData::deleteAll(['in', 'id', $ids['post_data_ids']]);
        
        
        $deleted['posts'] = $deleted['post_data'] - $deleted['threads'];
        $deleted['total'] = 
            $deleted['boards'] + $deleted['threads'] + 
            $deleted['posts'] + $deleted['post_data'] + 
            $deleted['post_messages'];
        
        return $deleted;
    }
    
    private static function getPostDataIds(Array $carry)
    {
        //get post data ids
        return $carry;
    }
    
    private static function getPostMessageIds(Array $carry)
    {
        //get post message ids
        return $carry;
    }
    
    public static function xclean()
    {
        $itemsToDelete = [
            'boardsIds' => [],
            'threadsIds' => [],
            'postsIds' => [],
            'postDataIds' => [],
            'postMessageIds' => []
        ];
        
        $itemsToDelete = 
            (new Board())->getDeletedRows((new Thread())->getDeletedRows((new Post())->getDeletedRows($itemsToDelete)));
        
        $itemsToDelete['postDataIds'] = self::getPostDataIds($itemsToDelete);
        $itemsToDelete['postMessageIds'] = self::getPostMessageIds($itemsToDelete);
        
        //del by ids
    }
}   