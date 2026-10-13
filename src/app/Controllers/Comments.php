<?php

namespace App\Controllers;

use App\Models\CommentModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class Comments extends BaseController
{
    private const PER_PAGE = 3;

    public function index(): string
    {
        $sort = $this->getSort();
        $direction = $this->getDirection();
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $model = new CommentModel();
        $total = $model->countAllResults();
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));
        $page = min($page, $totalPages);

        return view('comments/index', [
            'comments' => $model->orderBy($sort, $direction)
                ->findAll(self::PER_PAGE, ($page - 1) * self::PER_PAGE),
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'sort' => $sort,
            'direction' => strtolower($direction),
        ]);
    }

    public function create(): ResponseInterface
    {
        $rules = [
            'name' => 'required|valid_email|max_length[254]',
            'text' => 'required|max_length[3000]',
            'date' => 'required|regex_match[/^\\d{4}-\\d{2}-\\d{2}$/]',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $date = (string) $this->request->getPost('date');
        if (! $this->isRealDate($date)) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'errors' => ['date' => 'Укажите корректную дату.'],
            ]);
        }

        $model = new CommentModel();
        $id = $model->insert([
            'name' => trim((string) $this->request->getPost('name')),
            'text' => trim((string) $this->request->getPost('text')),
            'date' => $date,
        ]);

        return $this->response->setStatusCode(201)->setJSON([
            'success' => true,
            'id' => $id,
            'message' => 'Комментарий добавлен.',
        ]);
    }

    public function delete(int $id): ResponseInterface
    {
        $model = new CommentModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $model->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Комментарий удалён.',
        ]);
    }

    private function getSort(): string
    {
        return in_array($this->request->getGet('sort'), ['id', 'date'], true)
            ? (string) $this->request->getGet('sort')
            : 'id';
    }

    private function getDirection(): string
    {
        return strtolower((string) $this->request->getGet('direction')) === 'asc' ? 'ASC' : 'DESC';
    }

    private function isRealDate(string $value): bool
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);
        return $date !== false && $date->format('Y-m-d') === $value;
    }
}
