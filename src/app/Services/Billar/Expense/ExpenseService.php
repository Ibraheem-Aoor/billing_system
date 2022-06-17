<?php

namespace App\Services\Billar\Expense;

use App\Helpers\Core\Traits\FileHandler;
use App\Helpers\Core\Traits\HasWhen;
use App\Models\Billar\Expense\Expense;
use App\Services\Billar\ApplicationBaseService;

class ExpenseService extends ApplicationBaseService
{
    use FileHandler, HasWhen;

    public function __construct(Expense $expense)
    {
        $this->model = $expense;
    }
    public function checkValidation(): self
    {
        validator(request()->all(), [
            'name' => 'required|max:191',
            'reference' => 'required|max:191',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'purpose_id' => 'required|numeric',
            'attachment' => 'nullable|mimes:jpeg,jpg,gif,png,pdf,zip|max:2028',
            ],[
                'purpose_id.required' => 'The purpose field is required.',
                'purpose_id.numeric' => 'The purpose field is numeric value.'
        ])->validate();

        return $this;
    }

    public function saveAttachment($file): self
    {
        $this->deleteFile(optional($this->model->file)->path);

        $file_path = $this->storeFile(
            $file,
            'expense'
        );

        $this->model->attachment()->updateOrCreate([
            'type' => 'expense',
        ], [
            'path' => $file_path
        ]);

        return $this;
    }

    public function deleteAttachment(): self
    {
        $this->deleteFile(optional($this->model->attachment)->path);

        return $this;
    }
    public function deleteAttachmentData(): self
    {
        $this->model->attachment()->delete();

        return $this;
    }
}
