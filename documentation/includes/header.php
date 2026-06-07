<?php
require_once __DIR__ . '/../../config/bootstrap.php';
$pageTitle = $pageTitle ?? 'توثيق مشروع Hodoor';
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= clsHelper::e($pageTitle); ?> | Hodoor</title>
    <link rel="stylesheet" href="<?= clsPath::bootstrapCss(); ?>">
    <link rel="stylesheet" href="<?= clsPath::fontawesome(); ?>">
    <link rel="stylesheet" href="<?= clsPath::css(); ?>documentation.css">
    <link rel="icon" type="image/x-icon" href="<?= clsPath::assets(); ?>/images/favicon.png">
</head>
<body class="documentation-body">
<nav class="navbar navbar-expand-lg documentation-navbar py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="<?= clsPath::home(); ?>">
            <i class="fa fa-check-circle text-primary me-1"></i> Hodoor
        </a>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= clsPath::home(); ?>" class="btn btn-outline-secondary">
                <i class="fa fa-house me-1"></i> الرئيسية
            </a>
            <a href="<?= clsPath::login(); ?>" class="btn btn-primary">
                <i class="fa fa-right-to-bracket me-1"></i> دخول النظام
            </a>
        </div>
    </div>
</nav>
<div class="container documentation-layout">
