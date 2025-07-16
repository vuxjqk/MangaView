<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $chapterId = $request->query('chapter_id');
        $comments = Comment::where('chapter_id', $chapterId)
            ->with('user')
            ->latest()
            ->paginate(5);
        return response()->json([
            'comments' => $comments->items(),
            'total' => $comments->total(),
            'has_more' => $comments->hasMorePages(),
        ]);
    }

    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'chapter_id' => 'required|exists:chapters,id',
                'content' => 'required|string|max:1000',
            ]);

            $comment = Comment::create([
                'user_id' => Auth::id(),
                'chapter_id' => $validated['chapter_id'],
                'content' => $validated['content'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được thêm.',
                'comment' => [
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'username' => $comment->user->name,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể thêm bình luận: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        try {
            // Kiểm tra quyền
            if ($comment->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền chỉnh sửa bình luận này.'
                ], 403);
            }

            $validated = $request->validate([
                'content' => 'required|string|max:1000',
            ]);

            $comment->update([
                'content' => $validated['content'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được cập nhật.',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'updated_at' => $comment->updated_at->diffForHumans(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật bình luận: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        try {
            // Kiểm tra quyền
            if ($comment->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền xóa bình luận này.'
                ], 403);
            }

            $chapterId = $comment->chapter_id;
            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được xóa.',
                'chapter_id' => $chapterId
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa bình luận: ' . $e->getMessage()
            ], 500);
        }
    }
}
