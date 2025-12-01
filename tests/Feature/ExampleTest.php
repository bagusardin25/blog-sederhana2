<?php

it('redirects home to posts index', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('posts.index'));
});
