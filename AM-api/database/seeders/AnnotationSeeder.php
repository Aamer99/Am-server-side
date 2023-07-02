<?php

namespace Database\Seeders;

use App\Models\Annotation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newAnnotation = new Annotation();
        $newAnnotation-> name = "Image Annotation";
        $newAnnotation-> save();

        $newAnnotation = new Annotation();
        $newAnnotation-> name = "Text Annotation";
        $newAnnotation-> save();
        
    }
}