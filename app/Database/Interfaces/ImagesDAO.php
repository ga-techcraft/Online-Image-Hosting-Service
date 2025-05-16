<?php

namespace Database\Interfaces;

use Models\Images;

interface ImagesDAO{
    public function create(Images $images): bool;
    public function getById(int $id): ?Images;
    public function update(Images $images): bool;
    public function delete(int $id): bool;
    public function createOrUpdate(Images $images): bool;
}