@extends('admin.layoutAdmin')

@section('title', 'Admin Rivo Finanzas')

@section('content')

    @include('templates.admin.logo')
    @include('templates.admin.navBar')

    <main>
        <section class="container-custom p-3 pb-5">
            <article class="bg-light p-3">

                @include('templates.admin.title', ['title' => 'Panel de Administración'])

                
                
            </article>
        </section>
    </main>


@endsection