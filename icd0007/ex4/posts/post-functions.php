<?php

include_once 'Post.php';

const DATA_FILE = 'posts.txt';
const ID_FILE = 'next-id.txt';

//var_dump(getNewId());
$post = new Post(4, 'Web 2', 'Some text with other text');
savePost($post);

//deletePostById(1);
function getAllPosts(): array
{
    $lines = file(DATA_FILE);
    $result = [];

    foreach ($lines as $line) {
        [$id, $title, $text] = explode(';', trim($line));

        $post = new Post($id, urldecode($title), urldecode($text));

        $result[] = $post;
    }
    return $result;
}

function savePost(Post $post): string
{
    if ($post->id) {
        deletePostById($post->id);
    } else {

        $post->id = getNewId();
    }
    $line = asTextLine($post);
    file_put_contents(DATA_FILE, $line, FILE_APPEND);
    return $post->id;
}

function asTextLine(Post $post): string
{
    return sprintf("%s;%s;%s\n",
        $post->id,
        urldecode($post->title),
        urldecode($post->text));
}

function deletePostById(string $id): void
{
    $posts = getAllPosts();
    $data = '';
    foreach ($posts as $post) {
        if ($post->id !== $id) {
            $data .= asTextLine($post);
        }
    }
    file_put_contents(DATA_FILE, $data);
}

function getNewId(): string
{
    $id = file_get_contents(ID_FILE);
    file_put_contents(ID_FILE, intval($id) + 1);

    return $id;
}

function postsToString(array $posts): string
{
    $result = '';
    foreach ($posts as $post) {
        $result .= $post . PHP_EOL;
    }
    return $result;
}