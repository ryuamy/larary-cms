# CMS

CMS utama untuk kjgng

(semua tutorial yang ditulis di sini menggunakan web server XAMPP dan PHP ver 7.3.0)



## Table of Contents
* [Built With](#built-with)
* [Getting Started](#getting-started)
* [Not Work! What to do?](#not-work-what-to-do)
* [Additional information](#additional-information)



## Built With ##
* [PHP](https://www.php.net/) - General-purpose scripting language that is especially suited to web development. | version 7.3.0
* [Laravel](https://laravel.com/) - Web application framework with expressive, elegant syntax. | version 8.10.0
* [Composer](https://getcomposer.org/) - Dependency manager for PHP. | version 1.8.2
* [Metronic](https://keenthemes.com/metronic/) - Admin Theme | version 7.1.2

[[top]](#table-of-contents)



## Getting started

### Install Composer
Download composer melalui web ini [https://getcomposer.org/download/](https://getcomposer.org/download/) dan ikuti langkah-langkahnya. Composer digunakan sebagai dependency manager untuk menghubung antara project dengan library luar laravel. Restart komputer.

Setelah install composer, run **`composer install`** pada console untuk mendapatkan folder `vendor` sebagai wadah folder dependency atau library yang dipakai Laravel. 

### Install dependency package node.js
run **`npm install`** untuk menginstall package dependency tambahan, contohnya `Laravel Mix`, dan beberapa dependency lainnya yang akan dipakai kedepannya.

### Mengaktifkan enviroment beserta config
Copy file dari folder **`copyfile`** (asked me first) dan paste dengan path berikut:
* copyfile/.env ke .env (index path)

### Mengubah enviroment
Ubah beberapa property di bawah ini pada file **`.env`** menyesuaikan dengan local masing-masing
```properties
APP_NAME=(yourappname)
APP_ENV=local
APP_KEY=(generatekey)
APP_DEBUG=true
APP_URL=(yourappurl)
```

```properties
DB_HOST=(yourhostname)
DB_PORT=(yourhostpost)
DB_DATABASE=(yourdatabasename)
DB_USERNAME=(yourhostnameusername)
DB_PASSWORD=(yourhostnamepassword)
```
**`APP_ENV`** akan diubah menjadi staging atau production menyesuaikan enviroment ketika diupload ke server sedangkan untuk pengerjaan di local bisa menggunakan `local` atau `development`. **`APP_URL`** bisa tetap menggunakan `http://127.0.0.1:8081` atau disesuaikan dengan local masing-masing.

### Run database migration
Buat database di local masing-masing dengan nama yang sesuai dengan `DB_DATABASE` dan jalankan command **`php artisan migrate`** untuk mendapatkan table database.

### Run database seeder
Jalankan command **`php artisan db:seed --class=[seedername]`** untuk mengisi basic data seperti data admin dan lain-lain atau dummy data lainnya. Ubah text **`[seedername]`** menjadi nama file di folder **`database\seeders\`** tanpa format file atau **`.php`**. Contohnya **`php artisan db:seed --class=UsersSeeder`**.

### Run server
Jalankan command **`php artisan serve`** atau **`php artisan serve --port=8081`** jika `APP_URL` running di port 8081 untuk memulai project.

[[top]](#table-of-contents)



## Not Work! What to do?
* Jika kamu melakukan perubahan atau penambahan tetapi perubahan atau penambahan tersebut tidak berubah dari sebelumnya, jalankan command di bawah ini secara berurutan:
```command
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan clear-compiled
composer dump-autoload
```

* Jika kamu tidak bisa menjalankan perintah `php artisan` atau `composer` dan menemukan notif error seperti **`In ProviderRepository.php line 208: Class 'blabla\blabla\blabla' not found`**, buka folder **`bootstrap\cache\config.php`** dan hapus manually Class yang membuat error, contohnya `Intervention\Image\ImageServiceProvider`, di bagian array providers dan array aliases (biasany memilihi path yang sama, contohnya `'Intervention\Image\Facades\Image'`) dan rapikan kembali array nya. Setelah itu hapus folder `vendor` dan jalankan `composer dump-autoload` dilanjutan dengan menjalankan perintah `composer update`.

[[top]](#table-of-contents)



## Additional information

### Meng-ignore file untuk di local saja tanpa harus di push ke Git
Akses folder **`.git/info`**, ubah file **`exclude`**, tambahkan file atau folder yang ingin di ignore di local masing-masing, contoh **`notes/`**.

File ini berfungsi sama dengan **`.gitignore`** tapi hanya berlaku di local masing-masing dan tidak akan ter-push ke git.

[[top]](#table-of-contents)

---