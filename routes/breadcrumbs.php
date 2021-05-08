<?php

//Home
Breadcrumbs::for('home', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

//pages
Breadcrumbs::for('page.intro', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pengenalan', route('page.intro'));
});
Breadcrumbs::for('page.faq', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('FAQ', route('page.faq'));
});
Breadcrumbs::for('page.privacy', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Kebijakan Privasi', route('page.privacy'));
});
Breadcrumbs::for('page.contact', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Kontak Kami', route('page.contact'));
});
Breadcrumbs::for('page.term', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Syarat dan Ketentuan', route('page.terms'));
});
Breadcrumbs::for('page.about', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tentang Kami', route('page.about'));
});

//ikm
Breadcrumbs::for('ikm', function($breadcrumbs, $user_id, $username) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(ucwords($username), route('ikm.view', 'user_id'));
});

//Auth
Breadcrumbs::for('login', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Login', route('login'));
});
Breadcrumbs::for('verify', function($breadcrumbs) {
    $breadcrumbs->parent('login');
    $breadcrumbs->push('Verifikasi Data', route('auth.verify'));
});
Breadcrumbs::for('register', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Daftar', route('register'));
});
Breadcrumbs::for('reset', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Reset Password', route('password.request'));
});
Breadcrumbs::for('email', function($breadcrumbs) {
    $breadcrumbs->parent('reset');
    $breadcrumbs->push('Email', route('password.reset'));
});

//Project
Breadcrumbs::for('project', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Project', route('project'));
});
Breadcrumbs::for('project.view', function($breadcrumbs, $name, $url) {
    $breadcrumbs->parent('project');
    $breadcrumbs->push($name, route('project.view', 'url'));
});
Breadcrumbs::for('project.create', function($breadcrumbs) {
    $breadcrumbs->parent('project');
    $breadcrumbs->push('Buat Project', route('project.create'));
});
Breadcrumbs::for('project.bid', function($breadcrumbs, $url) {
    $breadcrumbs->parent('project');
    $breadcrumbs->push('Buat Bid', route('project.bid', 'url'));
});

//user
Breadcrumbs::for('user', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('User', route('user.update'));
});
Breadcrumbs::for('user.change_password', function($breadcrumbs) {
    $breadcrumbs->parent('user');
    $breadcrumbs->push('Ubah Password', route('user.change_password'));
});
Breadcrumbs::for('user.offer', function($breadcrumbs) {
    $breadcrumbs->parent('user');
    $breadcrumbs->push('Penawaran Saya', url('offer'));
});
Breadcrumbs::for('user.transaction', function($breadcrumbs) {
    $breadcrumbs->parent('user');
    $breadcrumbs->push('Transaksi Saya', url('transaction'));
});
Breadcrumbs::for('user.address', function($breadcrumbs) {
    $breadcrumbs->parent('user');
    $breadcrumbs->push('Alamat', url('address'));
});

//checkout
Breadcrumbs::for('checkout.address', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Alamat', route('checkout.address'));
});
Breadcrumbs::for('checkout.shipping', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pengiriman', route('checkout.shipping'));
});
Breadcrumbs::for('checkout.payment', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Pembayaran', route('checkout.payment'));
});

