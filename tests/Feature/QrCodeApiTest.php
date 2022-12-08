<?php

namespace Tests\Feature;

use Tests\TestCase;

class QrCodeApiTest extends TestCase
{
    /**
     * @return void
     */
    public function test_qr_code_api()
    {
        $response = $this->json('GET', route('qr-code'), [
            'Accept' => 'application/json',
            'backgroundcolor' => '222,222,255,0',
            'fillcolor' => '222,222,222,0',
            'size' => 500,
            'content' => 'Mvix USA'
        ], ['HTTP_Authorization' => 'Bearer ' . 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1IiwianRpIjoiODZiNjcwMzA0YTc5MjMxY2FiYTI1MWU4ODA4ZTNhN2U5YjFiZTU3M2U0NDQ2YjYxY2MwMTMyODc2NTc5MzNiMTRkNWUzZjlkODY2M2IxYTEiLCJpYXQiOjE2NzA0NDU0MzEuNjc3NTc3LCJuYmYiOjE2NzA0NDU0MzEuNjc3NTc5LCJleHAiOjE3MDE5ODE0MzEuNjcyNzk5LCJzdWIiOiI0MyIsInNjb3BlcyI6W119.ZkmG5xS6QROqnEs7HgXEE0ONbPJD9CEFNN15zuQKCxEd45mElLfFpQlcjBN390OF2ckPRe3BFfapCUCu9135XkS42dDK2iEE-DPbcETe5HBdXrNDsMri0liYuNCcxKIkS9dSp2FEFIBBEpq1-s55Zy5eFWWz665uDFeW1hZtiWdy8X3ddF-nrXMwU8pOzWTC0HiSVrimVMhwVe__mqb4lifw0gMCCzfY3cf9g1XqmwXJVYriswm0KVjpjFlHpUaV5Yk6yv7_-4lvdyyJmX-qiDmrlVj4fi4XIGq8NUZZNwsXcAuQGVNahI6J_HjkMtcorJK769f0tZ81md1tI2WeYMlPE4g8VDFMI9ifu8ZfaiYFpLK35y0hQlx-f20OdidxN9GsztBRKiZ6eZd4ZUUdwmq1bbUE7iZSUNKkwljwIKcdL91KOO_m1jpKvFFRQviWaQ9xf2Ny5oRx_4PIHd1XljXUVcGtG3UQOgf7xGtokt4caHmBcRPpHfbxUs57q2AGLYHjDtjA5tPZOlWmAely6ODVJE7B0aeJgeZwbWDCvyce-S85t3B3c4uGfwDXNjQOEVUxrK5la6HkqoIdBb6A-rxdPw0Ddn8OK6ReeLz3ofA3VkHC-7hwBzy9yjwZ-NtKvU-rk73uKxLKK_E_syEmyYJLxXMklYDbvg6VamWqHnI']);

        $response->assertStatus(200)->assertJsonStructure(['qr_code']);
    }
}
