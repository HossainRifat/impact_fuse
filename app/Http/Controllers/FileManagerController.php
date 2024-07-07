<?php

namespace App\Http\Controllers;

use App\Manager\FileUploadManager;
use App\Models\MediaGallery;
use App\Models\Traits\AppActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class FileManagerController extends Controller
{
    use AppActivityLog;

    /**
     * @param Request $request
     * @return RedirectResponse|BinaryFileResponse
     */
    final public function show_file(Request $request): RedirectResponse|BinaryFileResponse
    {
        if ($request->input('file')) {
            $file = Storage::disk('public')->path($request->input('file'));
            if ($request->input('action') == 'download') {
                return response()->download($file);
            } elseif ($request->input('action') == 'view') {
                return response()->file($file);
            }
        }
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    final public function delete_file(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            if ($request->input('media_gallery_id')) {
                $media_gallery = (new MediaGallery())->get_media_by_id($request->input('media_gallery_id'));
                if ($media_gallery) {
                    (new FileUploadManager())->delete($media_gallery->photo);
                    $original = $media_gallery->getOriginal();
                    $changed  = $media_gallery->getChanges();
                    self::activityLog($request, $original, $changed, $media_gallery);
                    $media_gallery->delete();
                    success_alert('Media Gallery Deleted Successfully');
                }
            }
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            app_error_log('MEDIA_GALLERY_DELETE_FAILED', $throwable, 'error');
            failed_alert($throwable->getMessage());
        }
        return redirect()->back();
    }
}
