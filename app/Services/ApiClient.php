<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    protected string $base;
    protected ?string $token = null;

    public function __construct()
    {
        // ✅ Base URL đọc từ .env (đã bao gồm /api)
        $this->base = rtrim(config('services.api.base'), '/');

        // 🆕 Ghi log kiểm tra để debug khi cần
        \Log::info('✅ API base URL: ' . $this->base);
    }

    public function setToken(?string $token): static
    {
        $this->token = $token;
        return $this;
    }

    protected function withToken()
    {
        // 🔥 Ưu tiên: token set trực tiếp > session > cookie
        $token = $this->token ?? session('api_token') ?? request()->cookie('api_token');

        $req = Http::baseUrl($this->base)->acceptJson();

        if ($token) {
            \Log::debug('🔑 Gọi API với token:', [substr($token, 0, 20) . '...']);
            return $req->withToken($token);
        }

        \Log::warning('⚠️ Gọi API không có token!');
        return $req;
    }


    public function get(string $path, array $query = [])
    {
        try {
            $url = ltrim($path, '/'); // ✅ loại bỏ dấu / đầu để tránh lỗi baseUrl
            $res = $this->withToken()->get($url, $query);
            \Log::info("🌍 GET {$this->base}/{$url}", ['query' => $query, 'status' => $res->status()]);
            return $res->throw()->json();
        } catch (\Throwable $e) {
            \Log::error("❌ Lỗi GET API: {$path}", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function post(string $path, array $data = [])
    {
        try {
            $url = ltrim($path, '/');
            $res = $this->withToken()->post($url, $data);
            \Log::info("🌍 POST {$this->base}/{$url}", ['data' => $data, 'status' => $res->status()]);
            return $res->throw()->json();
        } catch (\Throwable $e) {
            \Log::error("❌ Lỗi POST API: {$path}", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function postMultipart(string $path, array $fields = [], array $files = [])
    {
        $req = $this->withToken()->asMultipart();

        foreach ($fields as $k => $v)
            $req->attach($k, (string) $v);
        foreach ($files as $k => $file) {
            if (is_array($file)) {
                foreach ($file as $f)
                    $req->attach($k, fopen($f->getRealPath(), 'r'), $f->getClientOriginalName());
            } else {
                $req->attach($k, fopen($file->getRealPath(), 'r'), $file->getClientOriginalName());
            }
        }

        try {
            $url = ltrim($path, '/');
            $res = $req->post($url);
            \Log::info("🌍 MULTIPART {$this->base}/{$url}", ['status' => $res->status()]);
            return $res->throw()->json();
        } catch (\Throwable $e) {
            \Log::error("❌ Lỗi multipart upload: {$path}", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

}
