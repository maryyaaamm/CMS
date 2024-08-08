<?php
namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Post::all(['id', 'title', 'body', 'status', 'created_at']);
    }

    public function headings(): array
    {
        return ['ID', 'Title', 'Body', 'Status', 'Created At'];
    }
}
