@extends('layouts.main')
@section('title', 'Baixar Read Books')

@section('meta_title', 'Read Books - Download')
@section('meta_description', 'Faça o download do Read Books - Android, iOS e Windows')
@section('meta_keywords', 'livros, leitura, rede social, Read Books, download, baixar, readbooks, baixar read books, baixar readbooks, baixar read books android, baixar read books windows, baixar read books iOS')
@section('meta_image', asset('img/estante_icon_fundo.png'))
@section('meta_url', url()->current())

@section('content')
    <div class="container-download">
        <div class="download-section">
            <h1 class="title-bold">Baixe o Read Books</h1>
            <p class="text-gray"> &nbsp; </p>

            <div class="div-buttons gap-10">
                <button class="download-btn">
                    Baixar Read Books Desktop
                    <div class="dropdown-content">
                        <div class="wrap">

                        <a href="/download-app/windows/Instalador Read Books 1.0.0.exe">
                            <img src="/download-app/download-icon-windows.webp" class="download-icon"/>Baixar para Windows - AMD64
                        </a>
                        <a href="/download-app/windows/Instalador Read Books 1.0.0.exe">
                            <img src="/download-app/download-icon-windows.webp" class="download-icon"/>Baixar para Windows - ARM64
                        </a>
                        </div>
                    </div>
                </button>

                <a style="text-decoration: none" class="download-btn" target="_BLANK" href="https://play.google.com/store/apps/details?id=com.joaoenrique13.readbooks&pcampaignid=web_share">
                    <div class="">
                        Android (Google Play Store)
                    </div>
                </a>
                <p class="text-gray mt-5">Em breve disponivel para iOS e Linux</p>
            </div>

        </div>
    </div>

<style>
    .container-download {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        /* align-items: center; */
        padding-top: 100px;
        height: 100vh;
        background-color: var(--background-feed);
    }
    main{
        background-color: var(--background-feed);
    }   
    .download-section {
        text-align: center;
    }
    .download-btn {
        background-color: #5bb4ff !important;
        background-image: unset;
        border-color: #5bb4ff !important;
        border-radius: 6px;
        border-style: solid;
        border-width: 2px !important;
        box-shadow: none;
        box-sizing: border-box;
        color: #fff !important;
        cursor: pointer;
        display: inline-block;
        font-family: Roboto, sans-serif;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: -.225px;
        line-height: 1 !important;
        height: 54px;
        /* min-width: 196px; */
        width: 300px!important;
        padding: 18px 23px !important;
        position: relative;
        text-align: center;
        transition: all .3s ease 0ms;
    }
    /* body, #root{
        overflow: hidden;
    } */

    .img-download{
        width: 50%;
        margin-bottom: 100px
    }

    .download-btn:nth-child(0){
        margin-left: 5px;
    }

    .download-btn:nth-child(1){
        margin-right: 5px;
    }

    .dropdown-content {
        display: none;
        left: 50%;
        min-width: 360px;
        padding: 10px;
        position: absolute;
        transform: translateX(-50%);
        width: 100%;
        z-index: 99999;
        max-width: 500px;
    }
    .dropdown-content a {
        font-size: 16px;
        padding: 14px 16px;
        position: relative;
        align-items: center;
        color: #fff !important;
        display: flex;
        padding-right: 30px;
        text-decoration: none
    }
    .dropdown-content a:last-child {
        border-bottom: none;
    }
    .dropdown-content a:hover {
        /* background-color: #f0f0f0; */
        opacity: .5;
    }
    .download-btn:hover .dropdown-content {
        display: block;
    }

    h1.title-bold{
        color: #5bb4ff;
        font-size: clamp(40px, 8vw, 72px);
        font-weight: 800;
        line-height: 1;
    }

    p.text-gray{
        font-size: clamp(18px, 4vw, 24px);
        font-weight: 500;
        line-height: 1.3;
        color: #677285;
        margin-top: 5px;
        width: 100%;
    }

    .div-buttons{
        margin-bottom: 100px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }

    .wrap{
        background-color: #1a96fc;
        border-radius: 6px;
        padding: 16px;
        position: relative;
    }

    .wrap:before {
        background-color: #1a96fc;
        border-radius: 4px;
        content: "";
        height: 60px;
        left: 50%;
        position: absolute;
        top: 1px;
        transform: translateX(-50%) rotate(45deg);
        width: 60px;
        z-index: -1;
    }


    .download-icon{
        height: 20px;
        margin-right: 10px
    }

    .smart-download-button .drop-down .os-item {
        border-radius: 4px;
    }

    @media screen and (max-width: 770px){
        .container-download{
            padding-top: 50px!important;
        }

        .img-download{
            display: none;
        }

        .download-section{
            margin-top: 100px;
        }

        .download-btn:nth-child(0){
            margin-left: 0px;
        }
        
        .download-btn:nth-child(1){
            margin-right: 0px;
        }
    }
</style>

@endsection