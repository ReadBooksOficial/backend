<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/politica-privacidade', [NavigationController::class, 'politicaPrivacidade']);
Route::get('/compartilhar-livro/{user_id}', [LivroController::class, 'compartilharLivros'])->name('livros.compartilhar');
Route::get('/compartilhar-um-livro/{user_livro}', [LivroController::class, 'compartilharUmLivro'])->name('livros.compartilhar_um_livro');
Route::get('/livros/filtrar', [LivroController::class, 'filtrar'])->name('livros.filtrar');
Route::get('/como-compartilhar', [LivroController::class, 'comoCompartilhar'])->name('livros.como-compartilhar');

// NAVEGAÇÃO
Route::get('/', [NavigationController::class, 'index'])->name('index'); //página Home

Route::get('/pagina-nao-encontrada', [NavigationController::class, 'page_not_found'])->name('page_not_found'); //página Sobre

//USUARIO NÃO LOGADO
Route::group(['middleware' => 'guest'], function () {
    // Login
    Route::get('/login', [NavigationController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'login']);

    // Criar conta
    Route::get('/register', [NavigationController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'store']);
});


Route::get('/google-livro/{id}', [LivroController::class, 'googleLivro'])->name('google.livro');//deletar conta



//USUARIO LOGADO
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');//sair da conta

    Route::post('/delete-account/{id}', [UserController::class, 'deleteAccount'])->name('user.delete');//deletar conta
    Route::get('/edit', [NavigationController::class, 'edit'])->name('account.edit');//usuário logado apaga sua conta
    Route::post('/update-img', [UserController::class, 'updateImgAccount'])->name('account.update_img');//usuário logado apaga sua conta

    // LIVROS
    Route::get('/livro/{id}', [LivroController::class, 'consultarLivro'])->name('livros.consulta');//deletar conta
    Route::get('/editar/{id}', [LivroController::class, 'editar'])->name('livros.editar');//deletar conta
    Route::post('/update', [LivroController::class, 'update']);//deletar conta
    Route::get('/excluir/{id}', [LivroController::class, 'delete'])->name('livros.apagar');//deletar conta

    Route::get('/livros', [LivroController::class, 'listarLivros'])->name('livros.list');//deletar conta
    Route::get('/criar', [NavigationController::class, 'criarLivro'])->name('livros.cadastrar');//deletar conta
    Route::get('/conta', [NavigationController::class, 'conta'])->name('conta.view');//deletar conta
    Route::post('/update-user', [UserController::class, 'update'])->name('conta.editar');//deletar conta
    Route::get('/pesquisa', [LivroController::class, 'pesquisarLivro'])->name('livro.pesquisa');//deletar conta


    Route::post('/create', [LivroController::class, 'createLivro']);//deletar conta
    Route::get('/create/outro-livro/{book_title}', [LivroController::class, 'createOutroLivro']);//deletar conta
    // Route::post('/createDois', [LivroController::class, 'createLivroDois'])->name('livros.cadastrar.dois');//deletar conta
    Route::get('/resumo-leitura', [LivroController::class, 'resumo_leitura'])->name('livros.resumo');//deletar conta

    Route::post('/adicionar-leitura', [LivroController::class, 'adicionarLeitura']);//Adiciona livro da api na leitura


    // SÓ ADMIN PODE ACESSAR
    // Route::middleware('admin')->group(function () {
        //listagem de usuário
        Route::get('/admins', [UserController::class, 'listAdmin'])->name('admin.list_admins');//LISTAR ADMINS
        Route::get('/users', [UserController::class, 'listUser'])->name('admin.list_students');//LISTAR ALUNOS
        // Route::get('/create-admin', [NavigationController::class, 'create_admin'])->name('admin.create');//VIEW CRIAR ADMIN
        // Route::post('/create-admin', [AdminController::class, 'createAdmin'])->name('admin.create');//CRIAR ADMIN
        Route::get('/users/books/{id}', [LivroController::class, 'listarlivrosUsuario'])->name('admin.list_books_user');//CRIAR ADMIN


        Route::post('/switch-to-administrator/{id}', [AdminController::class, 'switch_to_administrator'])->name('admin.switch_to_administrator');//MUDAR CADASTRO PARA ADMIN
        Route::post('/switch-to-student/{id}', [AdminController::class, 'switch_to_student'])->name('admin.switch_to_student');//MUDAR CADASTRO PARA USUARIO COMUM

    // });
});



//API REACT
Route::get('/api/kjjgdlksabdgjhasudgafsvcdghcasdadffvd/books/{id_user}', [ApiController::class, 'getBooksByUserId']);
Route::get('/google-api/bookByName/{name}', [LivroController::class, 'bookByName']);
Route::get('/api/kjjgdlksabdgjhasudgafsvcdghcasdadffvd/login/{email}/{password}', [ApiController::class, 'login']);
Route::get('/api/kjjgdlksabdgjhasudgafsvcdghcasdadffvd/notifications/{id_user}', [ApiController::class, 'return_notifications_user']);
