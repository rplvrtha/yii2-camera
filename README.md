# Yii2 Camera

### Ekstensi Kamera Sederhana untuk Aplikasi Yii2

Ekstensi ini menyediakan widget yang mudah digunakan untuk mengakses kamera bawaan perangkat seluler dan mengunggah gambar ke server. Sangat cocok untuk aplikasi yang membutuhkan fitur pengambilan foto secara cepat tanpa kerumitan JavaScript yang kompleks.

## Fitur Utama

- Akses langsung ke kamera belakang perangkat seluler.

- Pratinjau gambar yang diambil.

- Unggah gambar ke server secara otomatis melalui AJAX.

- Antarmuka yang bersih dan sederhana dengan Bootstrap 5.

- Konfigurasi yang fleksibel untuk URL unggah dan callback.

## Persyaratan

- [PHP](https://php.net/) 7.4 atau lebih tinggi

- [Yii](https://yiiframework.com/) 2.0.42 atau lebih tinggi

## Instalasi

Cara termudah untuk menginstal ekstensi ini adalah melalui [Composer](https://getcomposer.org).

Jalankan perintah berikut di direktori root proyek Anda:

```bash
composer require rplvrtha/yii2-camera "dev-master"
```
## Penggunaan

### 1. Tambahkan widget di view anda

```php
<?php
use rplvrtha\camera\Yii2Cam;
use yii\helpers\Url;

echo Yii2Cam::widget([
    'uploadUrl' => Url::to(['site/upload-image']),
    'onSuccess' => 'handleSuccess',
    'onError' => 'handleError',
    'buttonText' => 'Ambil Foto',
]);

$this->registerJs(<<<JS
    // Fungsi callback yang dipanggil saat unggah berhasil
    function handleSuccess(response) {
        console.log('Gambar berhasil diunggah:', response);
        alert('Gambar berhasil disimpan di server!');
        // Contoh: menampilkan nama file dari respons server
        if (response.filename) {
            console.log('Nama file:', response.filename);
        }
    }

    // Fungsi callback yang dipanggil saat unggah gagal
    function handleError(error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengunggah gambar.');
    }
JS);
```

### 2. Buat action di controller untuk menangani unggahan file

```php
// dalam SiteController.php

public function actionUploadImage()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    if (Yii::$app->request->isPost) {
        $file = \yii\web\UploadedFile::getInstanceByName('imageFile');
        if ($file) {
            $fileName = 'camera_' . time() . '.' . $file->extension;
            $path = Yii::getAlias('@webroot/media/') . $fileName;

            if ($file->saveAs($path)) {
                return ['success' => true, 'filename' => $fileName];
            }
        }
    }
    return ['success' => false, 'message' => 'Gagal mengunggah file.'];
}
```

> **Catatan:**
>
> Pastikan direktori `web/media` sudah ada dan memiliki izin tulis.

## Konfigurasi Widget

|Properti|Tipe|Deskripsi|Default|
|---|---|---|---|
|`uploadUrl`|`string`|**URL untuk tujuan unggahan file.** Ini wajib diisi.|`null`|
|`onSuccess`|`string`|Nama fungsi JavaScript global yang akan dipanggil saat unggahan berhasil.|`null`|
|`onError`|`string`|Nama fungsi JavaScript global yang akan dipanggil saat unggahan gagal.|`null`|
|`buttonText`|`string`|Teks tombol utama.|`'Buka Kamera'`|
|`retakeText`|`string`|Teks tombol setelah gambar berhasil diambil.|`'Ambil Ulang Gambar'`|
|`previewWidth`|`string`|Lebar gambar pratinjau.|`'100%'`|
|`previewClass`|`string`|Kelas CSS tambahan untuk gambar pratinjau.|`''`|
---
Ekstensi ini dirilis di bawah lisensi **MIT**. Lihat berkas `LICENSE.md` untuk detailnya.
