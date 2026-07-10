<?php

namespace App\Controller;

class BookController {

    public function index(): void {
        echo "Book";
    }

    public function show(int $id): void {
        echo "Livre avec id: " . $id;
    }
}