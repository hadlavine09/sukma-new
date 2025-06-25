<!DOCTYPE html>
<html lang="en">

<head>
    <title>SukMa</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_frontend/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_frontend/css/style.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

</head>

<body>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <defs>
            <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-outline" viewBox="0 0 15 15">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    d="M7.5 9.804L5.337 11l.413-2.533L4 6.674l2.418-.37L7.5 4l1.082 2.304l2.418.37l-1.75 1.793L9.663 11L7.5 9.804Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-solid" viewBox="0 0 15 15">
                <path fill="currentColor"
                    d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
                <path fill="currentColor"
                    d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
            </symbol>
        </defs>
    </svg>

    <div class="preloader-wrapper">
        <div class="preloader">
        </div>
    </div>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart"
        aria-labelledby="My Cart">
        <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill">3</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Growers cider</h6>
                            <small class="text-body-secondary">Brief description</small>
                        </div>
                        <span class="text-body-secondary">$12</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Fresh grapes</h6>
                            <small class="text-body-secondary">Brief description</small>
                        </div>
                        <span class="text-body-secondary">$8</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">Heinz tomato ketchup</h6>
                            <small class="text-body-secondary">Brief description</small>
                        </div>
                        <span class="text-body-secondary">$5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>$20</strong>
                    </li>
                </ul>

                <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch"
        aria-labelledby="Search">
        <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Search</span>
                </h4>
                <form role="search" action="index.html" method="get" class="d-flex mt-3 gap-0">
                    <input class="form-control rounded-start rounded-0 bg-light" type="email"
                        placeholder="What are you looking for?" aria-label="What are you looking for?">
                    <button class="btn btn-dark rounded-end rounded-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <nav class="shopee-navbar" role="navigation" aria-label="Main navigation">
        <div class="container">
            <div class="navbar-left">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120"
                    height="108" viewBox="0 0 200 108">
                    <image id="logosukma" x="58" y="15" width="127" height="79"
                        xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHoAAABMCAYAAACieqNUAAAcHUlEQVR4nO1dCXxU1dU/b7KRQDbCvhgmAZFFNGRArUuUpVTbaauylMVqzUBQPsaF1mCwOE1tJCpUx/IJNNCiUkiiqI2ymLgEFC1MFBDZCpmEnZAFErLPzPt+J54bby7vzbw3DPoJ/n+/+WXmvvvudu5Z73kvEuhAVnF8KAAMB4ADGSnl9Xru5dFryUbstz8AXA0A13B/BwNAJABsM1+fWJrcP+5BAOgMAEcBYAcAvAEA+bMHxbn87ftKhWZCZxXHhwDAfwAgCQBOA8BNGSnlTq33D121624ASDxXV1HhdrsW4ndv9X8yeADcEN8NosIM4iD3AcCdswfFlV/pxNODYB11U4jIiJ642ADwv1puHLpqVxgA5AJASHRkj1ZZlt+qb6h5raW1aSwA3Kp0T0xEOJysd0Nlowe6hErQKUiCkCAJPLI8qNEl3wgAPxJaBww66g7lvrcCQLWOewcikel7iCRJk7t07mrrGtMnuktE7DMA0j8AoIG/Yc/RU9DsckGrR4aaJk8b0Y/UuuBYnTt49Sd7+vdasjEyEAtwpUCP6H4UAP4qFPfISCk/4+veoat2mQHg316q1Ho87rV19VU1brdrIm0MCA4yQL+uMdArJhKiIjqBQZLgTO15KCk9hpdrAOBpAFh96vE7a69sMvqGHtF9hPt+AMW2FiITBvq4HmUwBKVFR/bA7x82NNaubWo+n+xye+4sO1MtlZ2prgCArwDgFEmTaAAYRBvvEwD4UvfMNcLhtKOROIlUFxqNUQDgBoBj1O8GAHjbZLS2XKoxBAKKhM4qjked+joA3AAAHwBABgDs5Koczkgpt+vo3xeheYyJCI/Cz7HmloYJ9Q1n76JFTlEYL1rfey7FwjicdhMA/BkAfqZSpSsAjACA+wGgwuG0/wU3v8loddH9sWiwAsBVVBc3BzLGXrzM6n1XUONo3MET6fsDADAeAG4HALSy30YXR+f4Bvkxn34GKagSAOYCQJBKna9PPX5nqx9tq8LhtKM7lw0AD+tQbSiKfgEAxQ6n/VZas5Fe7q93OO2oyuwmo/XzQI5fDWqEFsv7AsBHAPAuAJzISCn/TGc/Xl0pFZyrq6+K90JkCLTIdjjtQwBgPfn0SsDYwQkA6EKeh4F8/DkAMAoAPiW/3xewzlT8OJx29EbmmoxWrWrQL6gR+l+kBxcAQHcq60eu0I3ynNDFtBhIwE4AcBLXSVra0iw2NHTVLrS24/0Y3A6SJN6w08d1zXA47Sii8yhgw6MKAF4CgHUmo/W/rNzhtCOxxwBAEwC8AgAJfnY9BQBuczjtZpPRWhKo+YhQdK8yUsrRsFgFAN0AoIWML+jU4gm6fXddvNsgnSJdU0BiHA2i4/Kc0N8qNDfAB1eqoUQDoQPC0Q6nfRp5BTyRZQB4GTezyWj9M09khMloPU+2xwYVIm8HgEVEyPEk2v+H1qtJqNsbjVCH0z4qEPNRgqrVnZFSXpdVHJ9EBkTctWWNM36+4+x0SYZYjwE8ALAZjRAAOEsW6GR0deQ5oR5pacvrXFP+iG1obW06okG37/J2MTM3VSKDavnCKSuPKtVxOO3TAeBVYdOjbTDdZLS+r3JPEHHxTOGSh9rKJeOx0mS05gl1ljqc9u5k4Fq5ftGaL0Aj0GS0HvMxb93QZGzIc0KvofBnlCxBa21EkBxd7w4R7kdu/iPtzhHS0pa28OjQVbvQmNJjobfhXF3FArfb9ReFSyfCg+vyTL02Nyb1LEJrNigjpVxccEZkjNzNRtqgeFw4ZWUjX8fhtE8kovBE3g8Ad5mM1vbwrsVmvg/1co6t4BWH0x5K9/xa6BKl3oNkiFlobZBzrzYZrWqbbCzZBFFc8YcAMM5ktMo6lssntEbGcthgJBlCouvdoTSRChJPKJLiAOBJAAil3c6gx7ViwMDJ9UJZU3RYZfbDSXM/mXndH+Ym9SzCvtKUbs7MTUWO+zsRGYGu0gq+Di3yv4Q1QFftNoHIVuLSJU8vv78nHayIREZxjJy4jebPGKATbX5FmIxWdF3votgAwxgS9wGFT0LLc0LRV7xZ4dIXFMRIB4C/AcBTFAt/BgAmyHNCf0n1/DFSsO2x3O/j4wesXnD/8KfmBhtaJws6/13+RiIyEiZVaHNGZm7qPPiGyOj6vMWFZYHUwBje+rXYzDYyxECSpCfNP01eAgBmod0XkDCksxFPCOHcaQ6nXTVcazJaPyUG4fG0w2nXE572CS2NjVYoQyvbSMTA06RltKuHUwwcOWKRPCc0yB8fuqW18TgFGRAVP09c/sKQuM+eB4AIoSpaxJvYj8zc1FAi8jSVpjPfcfxpIMUC+MU/SOKyjcgWm1my2MwvU4gV8ULab8cZFdp91mS0/oEXsyajtYIMWYbOGjgUVdsh7jeqyjt83KMLWgit5BeiNR5LlnEwicjZRPixtEPRJ72Pggm60NzcwDhNHtx1+x8TY77MVhnr6xkp5W0uHRH5DS9EhiCDYV7fuNhX6SycAT2ICSajFQ0wJDK28xqpI8Tbab8dV0WGE48FJqM1Q6WrFcLvX3ibv8lobSXJwCOg4lsLocsUykLIMh1K8d/jxEnrSJcnk4/7lAE8f9c7KJe7hYn7lROMq2aR3hPRQBEsnsiiWOXxjwmma0dTWJKhngyvtjlabOYIMo6m0/Wd0++9ZY0kSaJRaF+2ulAkZjtMRiuqNN4du02DKM4jV5bBl2upC1oI/bEwAAbk6nCaUBVZ3RZavDIy0hLX7XsAxeI5rYOSZfmsLMuoQ1vNA5dupU2jhGcyUspPZuamRpAv643IO8cmDcNQ4++E8gdMRmubL26xmaNJDfycrlX9ZNTVv4/sEr5KWKc3V7xWhPq8xGIzdwV1FHNXYn25mSajtUaICwygeHlA4JPQ0tKWc+ROKKGRQoEjSDevJONrKQA8hIsxrGHfw6TDfQHbeidYrn92WGTpE+aeW+8bGLNbJAzDWgB4joj8rmC4iagb3K/3grCQ4JeE8mc3bN+FMQAkcnciDEuC8ERFhltGDI1fJujy7atzi3M8HnkZHVasQX2u0q8YtTNqWAMxMubPGYEitB5TPku6T4xwhdPHQ6IcLd1mMi4OUkx40bJDjzw3e+BLWB6m0HZlXEjVi+uHTw7tFlL5KwBAa11qlA1gr+4v1m0icf1n16lxXYjIt3gbeGhw8GOJfXosIVeHYfPGHbsxKPF+Zm7q3Uf2VSA3X8ddt02755YZgmt46uNPv36ssanlXc5a/xkFPpT8/ePCby3exwnhd08N92iCIas4Xsoqjg/3Vlla2rJPwcDoUIV0tYsiZqhXswAAXY6Dt57bNpN8VhEb3xo+cfGWpDHp3UIqF9Jit3HI8dawtt2DiAtqhZvCz8GsmBPrn4wrf4GI/L4vIiPHjRs5DNOOBnNlJ7cfKH1OluUl1NfrVw3p8SVnKX88c8ZYTGS4l7untbK6bsb+QydWkBjmkWmxmZUs5LPC704KdUSICZf+hI4VwTj6CCX/HScz/yAFD3AB9maklCMB5wMAclwfhYaY+KohjjxE8e/fka9979Qzb0xb231iuyg2gGfNl6NGQbDkepY2xHmSAG3obHDDPZFnoHdwC0QZ2o9uUaqMuCHu67n/qRrmS6yVpoy45j1hg3nONzZZKs/VLeOkC/b5754DYm8+XVbT+46bh9mDggwdsmFkWZ73RsHnqIKGKfSD6m+txWZOyrEVnNSx9koQ1UDAjmANGSnlMhElmqxoJNTvAeCfAIAGTG1WcfxHz07u/fiRHqELfLTXnQ4DwikUiLu6EPXkU0eyUzgdtGWH6abmYMnFrFu01jfyDSGBB4c28EQGCk8O/2mvz5d2Dzurpr8RnrioLo907hT2slCeteWrA9MUdN+AsPCQtTMm3zp58MA+LwqBlLeXv1qEnHWPl/5QxK6z2Mw8B4pupcjhSugllFVpuEcTmDG2gf5WCpafhfQvJh08veb2uBmy1CEYoASJzq8ryNVaRtLhvq6uGtw8DS8PejS3k6HpQe5ePMZ8jAiphiYywhBDZw980ywEJngsueGaRAuFZRkcmxy793Ouk4iKLuGdnhfE/NE3Cj7HqN9zGhbzNkFXi5tJMd4tQDwHL9VwjyYwQr9DqS7I1c9TYB3IgDjINTT2xV/3/JSOKH0hlg7jgSzOiLf2Tg0PktyLx8R+NF+4F33Guykrw0JRth0UltxKYchkIRM1dWL/D/Jo3DwOjBs57GtSMwyNZacrf+/xyH9TGfPpm4YOXM/FxhGe6przD1ZW1y0XONwb0i02M3PzTEI9LTnwN/JjoihbQNBG6IyU8gryIUMoV2wt6bbBIpc1hRiiCpOi/qhgOIjgF6dNJHVrrZq52zTyKyEyxfAyBQ3Q8rRIw9tCr0mklzGjZbkYLRoSVTZZiHWjyJ4XGhy8mK8nA8zfW34cY/ExSgMNDwudF9ulsxiZei7v359N8+OYdbXFZjYShzMg0bxyp8NpTxbE/ac6+/UK3o9mu91AJz9OWvgDFwxqUOcsZ6+wR/zor4vAaSJ+QWrknLynbSO5SOStU7GwfylJMk/oxTdck5jKxckRWzZtbzu2HqfS5+o7rhsyXjAydx0uO52pYnz5AkqyXLfbw0uPrRruE0Oem1Tq+QWe0JvJyT9DQX83HVhsVvAJe627raulOUR6Rmenn4GkGukSEaEhoNNtdNe9zNItv+P6IdtJBTA0Hjx26k/yN1E6JVT8ZOigTZTJydBypKJq3oGKU2uCgg1TyNbQi1E5az7sQ+sIvpIpHU47M14ZcIO/6Ue/qmhfSLK+0fnfTa7Or0gXr6Uo1xqhkRuX3N0rUZbauE0rSlXcM79xbfQ3hz5hISHzwkNDRZG98NCJ0zgnxThBaHBwekyXiOeF4qw9ZcfQMLy776BueJDxGwU7wCdkWbaseXPrB6R23vFR38Ll5gHliet5EsYnOnBMRkr5RiLyDApehFDO19tk6t8rWIJTX7in1wFyz7SgUedjQD4RbHC37f6xSUNZDjXDl5t27K7xEh59d9zIYSMo6ZFh9ybHbicX737sqiE9+tEZs27UnW9a/K/1n+Ax5gVJkwIswm/dGTm+oLTocxT8NxfpqyAS7wvpeA9cQdLdXwyMmKbREu8ZSN8Qcd4VXj18QD+MWD3KFcunqs8tkGVZNLAYGoYP6LdUOHp0n66pRctcfOxoxVVDemz1Eu/3htDausZ1FEv3hjru2ocmo1WLTteFCwidkVJ+nHxND+WJ/YZykPeQn1hOEa9HKcm9dfPI6PGvju2WpXKkyeNaXwl9OlEXGT1g51U94jKFcOGyLw6VPaBmZUsAzyjcs7Tkv86ZgiEHFLpc371/9JN+PhWCEiHXYjN7O1dII+8hT7AXAgbV5MCs4vhZdJjRSSGzg+EQPdWBJ1xzb9tT987Ne8+vU4jwMLhgamsGxMhaAhBasL6ks71QyFGrKN69f2Z9U7OaXjzw0+ThrwQHBb3IlZ38cOfex5paWr3ZG5+cOFw1y9Xi3qa2gXzglRxbwcNaKzucdowZHArUM12q+jIjpXwFpcqqHXjgAv+BuBt3+tAtwyOv3zosciYX7nORX7yLPg54L7iMnvr4gsr2k2WrO67bZOjxOo2xHS6354n6pmY1KxuiO0c8HRwU1OGe5tbWJ5paWlXvIdzSJzHOSlkz/mRoPmSxmR/yVQkfJKDnuGoD+eCez3TfrOL4iZRaw05fttFTjBj5eYTK0SXbLIG0pX9k0mlTg7G3OzSsd2O3Xl1AksIpHSmKNpab00m1JA1wY5wNk6tqol1ft8a4d8ld3IfDJPD0IAOrH4VV+9Jv7HNzSWf7fhoDw0cbt+/aJFPmiQLeuGv0dS5SRwzvb9i+6z/esjUFpB3ZV9GHyyfTA+x7Qo6t4EP+HofT3o0SN6aRd/OSyWj1+NG+KjTldWcVxw+nAYygw457iHAfBBvClqb0TYsIkkLQHZsg5ChfDFiw5Ajp/jL2Pc71+dlmqYd0Pijhc+4Ezn30TPWYr5xH3+NPwTg0XJd41fS+cbFvcWXN+4+evLP0ZMVGlbNyJbSCDGOO7K+Yz1nneoDG7A2z7x8fTqm+95Ari4GiR0xG6yV5k4OeB+HD6FQLjZLKsKDOj6b0nT2SfOxul2JwXvB34uwJXBUMoRbWNjRKZacqw05Wn41xezwJdGAyQALIv3P0ddOF1CTbhu27RtOC68HphtqmOyqP1xZoCJGil/FlaEjwp6OSEk8Ov6Z/jCRJ47nHgFGaPGEyWrdcygXT9VYi+IbgvW7tMzMlPDhqMYnS7xr1dPjwGtdvDYm+Aq7MTfYBSoINZAes5K6X7ztywuQ8dWYqSSH2iSSJwAyuEJVM2B1H9lXgYctqUkFn6HOiU1jImSFX93UNTuwTFhPdeRAdViQLSY4YcXyekvgvOXQRmh5HeZG4WAk1FAnaT89j1Qh1JIoFx5Ab04P0bx96lEcp21OEjXQsf6T3CIUQk1Tu+RVJAf7Q4H7yKsKI6yrpbzVlmNbTxy34uUA2QifaENH0iaE4QS8vKc5ldFj0qsloveAM4VJC86stHE57NKXUiocDVcQpGM/94mKMCDJK+tDplpGOSY3c9zoiCE/kvUQQNSKj/r1ZWPytdF7MwrFxlAp1KbCHPBSMXW8L9DNVWqGJoynoXoSv/+KKmykvbAn3OMolhcNpRynwteCn4/nvn4jQ4nzcpH/f4bwGmbJo8jXmcemBq92N/OaYschktF5selFAoJWjVwtExpSgqeIzw98B5ghE/shktGJE6V2H0x5CHMrcsatIdaDfyxP0nwpletBIL9SroKPcg5Tbjupqt4a49vcCnxztcNrThLxsjB79zmS0ig9zX1I4nHYUr4dJHzKMNhmtO7yM/XoKzLB5NlAKbw0ZXcz4ClWJ/snk5zfSp8pktPr9aszvE1452uG0o1XNH/2hQZP2PemZxwUi53sjMuE5YTP/lROlTWQlXxHwdWSYybkW6A489H0ZE5SgyOCis3NVOJz224Xnl6ooH+6KhCqhHU57P+4k5TS96kH3AXwAwYcNMUR4yEfTYgIivodE8zNglxu8ie6Z3DEehuY0nyNbbOYEcsPYUw1FObaCi33jzkLKM8fN+Z7QH56gQY6tgE/Z4TNZnMIJ1w8GKnPTDW+EZslqO+mcVBMsNnM6vQWBPcKDx52LLDYzumeTc2wFYhBFE0hltBPYYjMnU9uTaEOVCrlZNoqe4anYzP/vr3DkoWFuuqEouh1OewKXyL5Eq1622Myz6HHZ8Tm2gvn44fTkOErZvWjQLnfQYmRTlK3DQ2wmo3U9LVK37yrM+F3NTWM7sfx3NY5mr7Oo1bqTqOFFopjG7xabeQUN/KJ2JQd2dox9ZZOquEA1/JC4mIOmucG3nJ9MGyFbkJaHLTZzKW32NDVCs3zmTTr8ZSZmlHYfdjj/YvUMfKsaWB/s3Dndx9OePwjomRsxloN+lpD0ZNdmES1wE9Tk2AqK1AjNsin1JJEzUZGA4ocnKu7MAC50Ov0txQlYbGZUCck5tgLFV1H9wKBnbpO47yID1XBlbWuvRmh2ALDNz3VajmIjAJZ2B3A7FbGCUxc/eCL7MTf+XL2Iv0BM1oH4iiFQh9P+Mb2rO0KHIZZAIUqGGjLKvBKbdm2sKNapvWTSVTVU5uAmmEjeQCmnw1aoWfWMO0iUreD6mCRKHNJ9CWxMrB5xWr5Cm/k5toJSoQ02/hKFa20ngMi1XJmuuVls5mpuY8zn58X1kcDKvLlXh/VEwXAyFps5mxM/OIhCi81sEicK3+ojZnjw+iWWNkwsLRK/2GwhSqkfZowwMTZJfIqRiLaI6uGkJ1EZa6NIpW+sm895ErFUJ5Hmyo+/Q78cEXDxu3Ll/D2TuXLNcyMCFgrLuYitocBw7euqFhmr8vOZo2zBQsTJ5vGmPgc1HdMh0KJSP4F7009Xrl4y4xb4lsi4KMnM5aMF5okn9tHeNxF5ufA6C7RBlkPH57naxSi5R6y+qDv5Ofg7N/HZtXwiaJFCW+19qHF0lT/vz0DRYrGZx3OLC/Q3XeBafgeLoo1PbOAXqoNOyrEV8BxRQvfVsI1GfRTSos33okL4BZ/FfU/gODWPs4YXUR9duf8UpDZ+Xlrwc84XVIzmuZGRNom7J01oixG6hp+zGkf7nYlInY4XODtd4Go1YqoOVFiMtoXANonrZtFC8JNO58Rntko77ZtMIAQbB7MxEoR70sQyhbnVCHbHJJX6uuYmjLNI0NsdNhPfgRqhvb1i4gJQB+2gztOEnLFkle/8rk/2IvZYH6U04WriqOWkMhIFfc64U/RB1TYZT4hSInINjal9rJyrcwHnUr8JfJnKnP2em5rEULjWYTOpEfoLhX85oAjBwGgHccJkrkiJ6CLXKu56YbGZmMzm2pykIr7EdmK9cBa/WXkLV21hlWyMDtJCpd9SXlX5MTfFPnz1r0hoel91o9I1HjSBdLVYLOc+iD51u37mBpPMWezAJk198DHyEvg2CFMitCcuHAgbLF0wrEq4e2aJ5QR+bjyheRujhsbJH/7wbfDj54k8S4kLfcyNHydw12bx19h6U3myN/dqn5drDO2hNhRbCv4i28VqkbEE+Nbny6PJsYnFkijME4jDE44tEhOdzMrOFuoUkeRJprrsPhw3ECH4ckXjils8njiMyKLLk8AFPfjNwtw0dsrHj1XL3Hgkk7HGiNw+B1r7BOrD5C3DZJvDaff1eE0+N7hFwokJO63K5h15AltIXAyZJjBf0F155A+WaIh8jbPYzIUq7aAhKNNCTBaIWEj98CoGBANNTecyJFPMOV8Y53LSs8lknLJ1SqbxpCsYrVrmxm+MRdQH8w74ueVxBmWpN0Jv8PUaClqQRBaIoBOTQoryLCJLUcz0AGGwzPBZQe2wBakht0gkco1KO7GsHRoXf62EGVfCJsByk6BWlMRzh/NgUkn8omaTuM0XCJfN9cuPp0ihX01zo/JSoR7rg1+/fD4y6TUL1OG0SzpCoLH8wihFw4T6yRT6LBLKWTslouugEmFr61PJT1a7Rpway5erqJ4EMhgvCKt6GScrv2ANvI1Hz9x89HHB3H7Ej/gRlxt0P02phMzcVBQlsQunrGwXI5m5qW1ib+GUlReIPaoPSte4e0HL/Up9C220QRhbrPg6ZvH+yw2BehUUGl+HM3NTx9FCziKL2aFSv5DqX3DYwd17mOoUKtRzcEEatC4LecLS98NCOzzhF/m4ftkhoO/84gIeik49EYGdwMR6q8e5EuPU6mXmpuYx90WFI7PJ5UkTrq/gDlmKFK5fdggkoVHEjsvMTWWBCbW03nRyD4qEMKII0YURMYk+3oiUzG2qdiycsrKEc5dKF05Z+YPPN/OFQBK6iIibTr6kkm5N4DZBm4vAxL0CHFy0TCmpMJba8bZZfgQh0BydzWVnKIERJZYjlJr4Hs84WoVj86m/SaTXlVDCNt3lroN9IdA6Op+l4IgXyKBqS91ZOGVlIn6YDlYhQinpUeR6pXeAoUXOolGLVNpIp1Dkci+vcb4iEChCY5x1PnLewikr08glMvF5VFxZGleGhDLxHEv6MpHayqcQq3goYmLG1MIpKycrtMFCs+0fUQ9zdZRCtJcXAOD/ABBhnWEFDxPKAAAAAElFTkSuQmCC" />
                </svg>
            </div>
            <div class="navbar-center">
                <form action="#" method="GET" class="search-form" role="search"
                    aria-label="Product search form" onsubmit="return false;">
                    <div class="search-input-wrapper">
                        <input type="text" name="q" id="search-input"
                            placeholder="Cari produk, brand, dan lainnya" autocomplete="off" aria-autocomplete="list"
                            aria-controls="search-suggestions" aria-expanded="false" />
                        <button type="submit" aria-label="Search">
                            <svg fill="#777" height="20" width="20" viewBox="0 0 24 24"
                                aria-hidden="true" focusable="false">
                                <path
                                    d="M21.71 20.29l-3.388-3.388a7.918 7.918 0 001.62-5.092C19.942 7.015 16.927 4 13.221 4S6.5 7.015 6.5 10.71c0 3.696 3.015 6.71 6.721 6.71a7.918 7.918 0 005.092-1.62l3.388 3.388c.39.39 1.025.39 1.414 0a1 1 0 000-1.414zM8 10.71a5.22 5.22 0 015.221-5.21 5.22 5.22 0 015.22 5.21 5.22 5.22 0 01-5.22 5.21A5.22 5.22 0 018 10.71z" />
                            </svg>
                        </button>
                    </div>
                    <ul id="search-suggestions" role="listbox" class="suggestions" hidden></ul>
                </form>
            </div>
            <div class="navbar-right">
                <div class="nav-cart-dropdown-wrapper position-relative" style="display:inline-block;">
                    <a href="#" class="nav-icon" aria-label="Keranjang Belanja" title="Keranjang Belanja"
                        id="cartDropdownBtn">
                        <svg fill="#fff" height="24" width="24" viewBox="0 0 24 24" aria-hidden="true"
                            focusable="false">
                            <path
                                d="M7 18c-1.104 0-2 .895-2 2 0 1.104.896 2 2 2 1.104 0 2-.896 2-2 0-1.105-.896-2-2-2zm10 0c-1.104 0-2 .895-2 2 0 1.104.896 2 2 2 1.104 0 2-.896 2-2 0-1.105-.896-2-2-2zM7.2 13h9.599c.75 0 1.423-.436 1.734-1.115l3.732-7.221-1.972-.972-3.069 5.917-5.727-.008L6.473 2.28A1 1 0 005.58 2H2v2h2.41l3.413 9.336a1.001 1.001 0 00.38.384l.998.6a1.007 1.007 0 00.999 0z" />
                        </svg>
                    </a>
                    <div id="cartDropdownCard"
                        class="cart-dropdown-card card shadow border-0 position-absolute end-0 mt-2"
                        style="min-width:320px; z-index:1000; display:none; opacity:0; transform:translateY(10px); transition:opacity 0.25s, transform 0.25s;">
                        <div class="card-body p-3">
                            <h6 class="mb-3">Keranjang Belanja</h6>
                            <ul class="list-group mb-3">
                                {{-- Cart items will be injected by JS --}}
                                <li class="list-group-item text-center text-muted py-4 empty-cart-message"
                                    style="display:none;">
                                    Keranjang masih kosong.
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total</span>
                                    <strong>Rp0</strong>
                                </li>
                            </ul>
                            <a href="" class="btn btn-primary w-100" id="lihatKeranjangBtn">Lihat
                                Keranjang</a>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const cartList = document.querySelector('#cartDropdownCard ul.list-group');
                            const totalDisplay = cartList.querySelector('li:last-child strong');
                            const emptyMsg = cartList.querySelector('.empty-cart-message');

                            function formatRupiah(angka) {
                                return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            }

                            function loadCartData() {
                                fetch('{{ route('keranjang.json') }}')
                                    .then(response => response.json())
                                    .then(data => {
                                        let total = 0;
                                        // Hapus item yang sudah ada (kecuali 2: pesan kosong & total)
                                        const items = cartList.querySelectorAll('li:not(.empty-cart-message):not(:last-child)');
                                        items.forEach(item => item.remove());

                                        if (data.length === 0) {
                                            emptyMsg.style.display = '';
                                        } else {
                                            emptyMsg.style.display = 'none';

                                            data.forEach(item => {
                                                const li = document.createElement('li');
                                                li.className =
                                                    'list-group-item d-flex justify-content-between align-items-center';

                                                li.innerHTML = `
                                <div>
                                    <div class="fw-bold">${item.nama_produk}</div>
                                    <div class="text-muted small">${item.nama_kategori}</div>
                                    <div class="small">Qty: ${item.qty}</div>
                                </div>
                                <div class="text-end">
                                    <div>${formatRupiah(item.harga)}</div>
                                </div>
                            `;

                                                cartList.insertBefore(li, cartList.querySelector('li:last-child'));
                                                total += item.harga * item.qty;
                                            });
                                        }

                                        totalDisplay.textContent = formatRupiah(total);
                                    })
                                    .catch(error => {
                                        console.error('Gagal memuat data keranjang:', error);
                                    });
                            }

                            // Panggil fungsi saat halaman selesai dimuat
                            loadCartData();

                            // Optional: refresh otomatis saat dropdown dibuka
                            document.getElementById('cartDropdownCard').addEventListener('mouseenter', loadCartData);
                        });
                    </script>

                </div>
                <style>
                    .cart-dropdown-card.show {
                        display: block !important;
                        opacity: 1 !important;
                        transform: translateY(0) !important;
                        pointer-events: auto;
                    }

                    .cart-dropdown-card.hiding {
                        opacity: 0 !important;
                        transform: translateY(10px) !important;
                        pointer-events: none;
                        transition: opacity 0.25s, transform 0.25s;
                    }
                </style>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const cartBtn = document.getElementById('cartDropdownBtn');
                        const cartCard = document.getElementById('cartDropdownCard');
                        const wrapper = cartBtn.closest('.nav-cart-dropdown-wrapper');
                        let hideTimeout = null;

                        function showCartCard() {
                            clearTimeout(hideTimeout);
                            cartCard.style.display = 'block';
                            cartCard.classList.remove('hiding');
                            void cartCard.offsetWidth;
                            cartCard.classList.add('show');
                        }

                        function hideCartCard() {
                            cartCard.classList.remove('show');
                            cartCard.classList.add('hiding');
                            hideTimeout = setTimeout(() => {
                                cartCard.style.display = 'none';
                                cartCard.classList.remove('hiding');
                            }, 250);
                        }

                        wrapper.addEventListener('mouseenter', showCartCard);
                        wrapper.addEventListener('mouseleave', function() {
                            hideTimeout = setTimeout(hideCartCard, 120);
                        });

                        cartBtn.addEventListener('focus', showCartCard);
                        cartBtn.addEventListener('blur', function() {
                            hideTimeout = setTimeout(hideCartCard, 120);
                        });
                        cartCard.addEventListener('mouseenter', function() {
                            clearTimeout(hideTimeout);
                        });
                        cartCard.addEventListener('mouseleave', function() {
                            hideTimeout = setTimeout(hideCartCard, 120);
                        });
                    });
                </script>
                <!-- User logged out state -->
                <style>
                    .profile-btn {
                        background-color: #e5e7eb;
                        border-radius: 9999px;
                        width: 2rem;
                        height: 2rem;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: #000;
                        font-weight: bold;
                        cursor: pointer;
                        position: relative;
                        z-index: 101;
                    }

                    .profile-dropdown-wrapper {
                        position: relative;
                        display: inline-block;
                    }

                    .profile-dropdown {
                        position: absolute;
                        top: 110%;
                        right: 0;
                        min-width: 10rem;
                        background-color: #fff;
                        border: 1px solid #ddd;
                        border-radius: 0.25rem;
                        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
                        display: none;
                        z-index: 100;
                    }

                    .profile-dropdown.show {
                        display: block;
                    }

                    .profile-dropdown a,
                    .profile-dropdown button {
                        display: block;
                        width: 100%;
                        text-align: left;
                        padding: 0.5rem 1rem;
                        color: #333;
                        background: none;
                        border: none;
                        cursor: pointer;
                        font-size: 0.9rem;
                    }

                    .profile-dropdown a:hover,
                    .profile-dropdown button:hover {
                        background-color: #f3f4f6;
                    }
                </style>
                @auth
                    @php
                        $emailInitial = strtoupper(substr(Auth::user()->email, 0, 1));
                    @endphp
                    <div class="profile-dropdown-wrapper">
                        <div class="profile-btn" onclick="toggleDropdown(event)">
                            {{ $emailInitial }}
                        </div>
                        <div id="dropdown" class="profile-dropdown">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5 mr-2 text-gray-600"
                                    fill="none" height="24" width="24" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A4.992 4.992 0 0112 15a4.992 4.992 0 016.879 2.804M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                                </svg>
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="inline-block w-5 h-5 mr-2 text-gray-600" fill="none" height="24"
                                        width="24" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('register2') }}" class="nav-login" tabindex="0">Daftar</a>
                    <span class="mx-1 text-black">|</span>
                    <a href="{{ route('login') }}" class="nav-login" tabindex="0">Login</a>
                @endauth

                <script>
                    function toggleDropdown(event) {
                        event.stopPropagation();
                        var dropdown = document.getElementById("dropdown");
                        dropdown.classList.toggle("show");
                    }

                    // Menutup dropdown saat klik di luar elemen
                    document.addEventListener('click', function(event) {
                        var profileBtn = document.querySelector('.profile-btn');
                        var dropdown = document.getElementById('dropdown');
                        if (!profileBtn.contains(event.target) && !dropdown.contains(event.target)) {
                            dropdown.classList.remove('show');
                        }
                    });
                </script>


                <!-- If user logged in, replace above with user dropdown -->
                <!--
                <div class="nav-user-dropdown" tabindex="0" aria-haspopup="true" aria-expanded="false" aria-label="User account menu">
                    Nama Pengguna
                    <ul class="dropdown-menu" role="menu" hidden>
                        <li><a href="#">Profil Saya</a></li>
                        <li>
                            <button type="button" onclick="alert('Logout function here')">Keluar</button>
                        </li>
                    </ul>
                </div>
                -->
            </div>
        </div>
    </nav>

    <style>
        .split-hero {
            display: flex;
            min-height: 500px;
            box-shadow: 0 15px 8px rgba(0, 0, 0, 0.1);
        }

        .left-side {
            flex: 1;
            background-color: #f5f6ef;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-side {
            flex: 1;
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom right, #80a78a 0%, #6FA36F 30%, #2d5727 100%);
        }


        .left-side h1 {
            font-size: 2.5rem;
            color: #1b4d3e;
            margin-bottom: 1rem;
        }

        .left-side p {
            font-size: 1rem;
            color: #444;
            margin-bottom: 1.5rem;
        }

        .cta-btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #3c9d40;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            max-width: fit-content;
        }

        .right-side img {
            max-width: 100%;
            height: auto;
            border-radius: 1rem;
        }
    </style>
    <section class="split-hero">
        <div class="left-side">
            <h1>Eusc Frendily <br> Preccincercy</h1>
            <p>Loereth bssumrutiohen amametr, erers, crasmctcoeciensticsiplär cerealbaiub di nudjioptent ershufadt...
            </p>
            <a href="#" class="cta-btn">LEERES UMAR-UP CLICK</a>
        </div>
        <div class="right-side">
            <img src="{{ asset('assets_frontend/images/hero-img-1.png') }}" alt="Eco Products">
        </div>
    </section>


    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Category</h2>

                        <div class="d-flex align-items-center">
                            <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                                <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('assets_frontend/images/icon-vegetables-broccoli.png') }}"
                                    alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('assets_frontend/images/icon-bread-baguette.png') }}"
                                    alt="Category Thumbnail">
                                <h3 class="category-title">Breads & Sweets</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('assets_frontend/images/icon-soft-drinks-bottle.png') }}"
                                    alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('assets_frontend/images/icon-wine-glass-bottle.png') }}"
                                    alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('assets_frontend/images/icon-animal-products-drumsticks.png') }}"
                                    alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                            <a href="index.html" class="nav-link category-item swiper-slide">
                                <img src="{{ asset('assets_frontend/images/icon-bread-herb-flour.png') }}"
                                    alt="Category Thumbnail">
                                <h3 class="category-title">Fruits & Veges</h3>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>





    {{-- <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap flex-wrap justify-content-between mb-5">

                        <h2 class="section-title">Newly Arrived Brands</h2>

                        <div class="d-flex align-items-center">
                            <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev brand-carousel-prev btn btn-yellow">❮</button>
                                <button class="swiper-next brand-carousel-next btn btn-yellow">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="brand-carousel swiper">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="card mb-3 p-3 rounded-4 shadow border-0">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{asset('assets_frontend/images/product-thumb-11.jpg')}}" class="img-fluid rounded"
                                                alt="Card title">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body py-0">
                                                <p class="text-muted mb-0">Amber Jar</p>
                                                <h5 class="card-title">Honey best nectar you wish to get</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card mb-3 p-3 rounded-4 shadow border-0">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{asset('assets_frontend/images/product-thumb-12.jpg')}}" class="img-fluid rounded"
                                                alt="Card title">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body py-0">
                                                <p class="text-muted mb-0">Amber Jar</p>
                                                <h5 class="card-title">Honey best nectar you wish to get</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card mb-3 p-3 rounded-4 shadow border-0">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{asset('assets_frontend/images/product-thumb-13.jpg')}}" class="img-fluid rounded"
                                                alt="Card title">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body py-0">
                                                <p class="text-muted mb-0">Amber Jar</p>
                                                <h5 class="card-title">Honey best nectar you wish to get</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card mb-3 p-3 rounded-4 shadow border-0">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{asset('assets_frontend/images/product-thumb-14.jpg')}}" class="img-fluid rounded"
                                                alt="Card title">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body py-0">
                                                <p class="text-muted mb-0">Amber Jar</p>
                                                <h5 class="card-title">Honey best nectar you wish to get</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card mb-3 p-3 rounded-4 shadow border-0">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{asset('assets_frontend/images/product-thumb-11.jpg')}}" class="img-fluid rounded"
                                                alt="Card title">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body py-0">
                                                <p class="text-muted mb-0">Amber Jar</p>
                                                <h5 class="card-title">Honey best nectar you wish to get</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card mb-3 p-3 rounded-4 shadow border-0">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{asset('assets_frontend/images/product-thumb-12.jpg')}}" class="img-fluid rounded"
                                                alt="Card title">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body py-0">
                                                <p class="text-muted mb-0">Amber Jar</p>
                                                <h5 class="card-title">Honey best nectar you wish to get</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section> --}}


    <style>
        /* Responsive Product Tabs & Grid */
        .product-tabs .tabs-header {
            flex-direction: column;
            gap: 1rem;
        }

        .product-tabs .tabs-header h3 {
            margin-bottom: 0.5rem;
        }

        .product-tabs .nav-tabs {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .product-tabs .nav-link {
            margin-bottom: 0.25rem;
        }

        .product-grid {
            gap: 1.5rem 0;
        }

        .product-item {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            padding: 1.25rem 1rem 1rem 1rem;
            position: relative;
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-item figure {
            margin: 0 0 1rem 0;
            text-align: center;
        }

        .product-item img.tab-image {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        .product-item h3 {
            font-size: 1.1rem;
            margin: 0 0 0.25rem 0;
            font-weight: 600;
        }

        .product-item .qty,
        .product-item .rating {
            font-size: 0.9rem;
            color: #888;
            margin-right: 0.5rem;
        }

        .product-item .price {
            font-size: 1.1rem;
            font-weight: bold;
            color: #2d5727;
            margin-bottom: 0.5rem;
            display: block;
        }

        .product-item .btn-wishlist {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background: #f5f6ef;
            border-radius: 50%;
            padding: 0.25rem;
            z-index: 2;
        }

        .product-item .badge {
            left: 0.75rem;
            top: 0.75rem;
            z-index: 2;
        }

        .product-item .input-group.product-qty {
            max-width: 120px;
        }

        .product-item .input-group .form-control {
            text-align: center;
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
            height: 2rem;
        }

        .product-item .input-group-btn .btn {
            padding: 0.25rem 0.5rem;
            font-size: 1rem;
        }

        .product-item .nav-link {
            font-size: 0.95rem;
            font-weight: 500;
            color: #2d5727;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            background: #f5f6ef;
            transition: background 0.2s;
        }

        .product-item .nav-link:hover {
            background: #e0e7e9;
            color: #1b4d3e;
        }

        /* Responsive grid columns */
        @media (max-width: 1199.98px) {
            .product-grid.row-cols-xl-5>.col {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        @media (max-width: 991.98px) {
            .product-grid.row-cols-lg-4>.col {
                flex: 0 0 25%;
                max-width: 25%;
            }
        }

        @media (max-width: 767.98px) {
            .product-grid.row-cols-md-3>.col {
                flex: 0 0 33.3333%;
                max-width: 33.3333%;
            }

            .product-tabs .tabs-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 575.98px) {
            .product-grid.row-cols-sm-2>.col {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .product-item {
                padding: 1rem 0.5rem 0.75rem 0.5rem;
            }

            .product-item h3 {
                font-size: 1rem;
            }

            .product-item .price {
                font-size: 1rem;
            }
        }

        @media (max-width: 400px) {
            .product-grid.row-cols-1>.col {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .product-item {
                padding: 0.75rem 0.25rem 0.5rem 0.25rem;
            }
        }
    </style>
    <section class="">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="bootstrap-tabs product-tabs">
                        <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                            <h3>Trending Products</h3>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a href="#" class="nav-link text-uppercase fs-6 active" id="nav-all-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
                                    <a href="#" class="nav-link text-uppercase fs-6" id="nav-fruits-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-fruits">Fruits & Veges</a>
                                    <a href="#" class="nav-link text-uppercase fs-6" id="nav-juices-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-juices">Juices</a>
                                </div>
                            </nav>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                                aria-labelledby="nav-all-tab">
                                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5"
                                    id="product-grid">
                                    <!-- Produk akan dimuat secara dinamis melalui SSE -->
                                </div>


                                <script>
                                    const productGrid = document.getElementById('product-grid');

                                    const formatRupiah = (number) => {
                                        return new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(number);
                                    };

                                    // Render produk dan pasang event handler setelah render
                                    const renderProducts = (products) => {
                                        productGrid.innerHTML = '';
                                        products.forEach(item => {
                                            const diskonBadge = item.diskon > 0 ?
                                                `<span class="badge bg-success position-absolute m-3">-${item.diskon}%</span>` :
                                                '';

                                            const tags = item.tags && item.tags.length ?
                                                `<div class="mt-1 small text-muted">Tags: ${item.tags.join(', ')}</div>` :
                                                '';

                                            const html = `
                                                <div class="col">
                                                    <div class="product-item text-decoration-none text-dark" style="cursor:pointer;">
                                                        <a href="/detail/${item.id}" style="text-decoration: none;">
                                                            ${diskonBadge}
                                                            <span class="btn-wishlist">
                                                                <svg width="24" height="24"><use xlink:href="#heart"></use></svg>
                                                            </span>
                                                            <figure>
                                                                <img src="{{ asset('storage/${item.gambar_produk}') }}" class="tab-image" alt="${item.nama_produk}">
                                                            </figure>
                                                            <h3>${item.nama_produk}</h3>
                                                            <span class="rating">
                                                                <svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg> 4.5
                                                            </span>
                                                            <span class="price">${formatRupiah(item.harga_produk)}</span>
                                                        </a>
                                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                                            <div class="input-group product-qty">
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                                                        <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                                                    </button>
                                                                </span>
                                                                <input type="text" name="quantity" class="form-control input-number" value="1">
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                                                        <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <span class="nav-link add-to-cart-btn" style="cursor:pointer;">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></span>
                                                        </div>
                                                        ${tags}
                                                    </div>
                                                </div>
                                            `;
                                            productGrid.insertAdjacentHTML('beforeend', html);
                                        });

                                        // Pasang event handler qty dan add to cart setelah render
                                        setupProductEvents();
                                    };

                                    // SSE produk
                                    const evtSource = new EventSource("{{ route('frontend.GetProdukFrontEnd') }}");
                                    evtSource.onmessage = function(event) {
                                        const data = JSON.parse(event.data);
                                        if (data.status === 'success') {
                                            renderProducts(data.produk);
                                        } else {
                                            console.error("Error fetching products:", data.message);
                                        }
                                    };
                                    evtSource.onerror = function(err) {
                                        console.error("SSE connection error:", err);
                                    };

                                    // --- Cart Logic ---
                                    let cart = [];
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const cartBtn = document.getElementById('cartDropdownBtn');
                                        const cartCard = document.getElementById('cartDropdownCard');
                                        const cartList = cartCard.querySelector('ul.list-group');
                                        const cartTotal = cartCard.querySelector('strong');
                                        const cartDropdownWrapper = document.querySelector('.nav-cart-dropdown-wrapper');

                                        function formatRupiah(num) {
                                            return 'Rp' + num.toLocaleString('id-ID');
                                        }

                                        function updateCartDropdown() {
                                            cartList.querySelectorAll('li:not(:last-child)').forEach(li => li.remove());
                                            let total = 0;
                                            cart.forEach(item => {
                                                total += item.price * item.qty;
                                                const li = document.createElement('li');
                                                li.className = "list-group-item d-flex justify-content-between lh-sm";
                                                li.innerHTML = `
                                                    <div>
                                                        <h6 class="my-0">${item.name}</h6>
                                                        <small class="text-body-secondary">${item.desc}</small>
                                                        <span class="badge bg-secondary ms-2">${item.qty}x</span>
                                                    </div>
                                                    <span class="text-body-secondary">${formatRupiah(item.price * item.qty)}</span>
                                                `;
                                                cartList.insertBefore(li, cartList.lastElementChild);
                                            });
                                            cartTotal.textContent = formatRupiah(total);
                                        }

                                        // --- Animate to Cart ---
                                        function animateToCart(img, startRect, endRect) {
                                            const flyingImg = img.cloneNode(true);
                                            flyingImg.style.position = 'fixed';
                                            flyingImg.style.zIndex = 2000;
                                            flyingImg.style.left = startRect.left + 'px';
                                            flyingImg.style.top = startRect.top + 'px';
                                            flyingImg.style.width = startRect.width + 'px';
                                            flyingImg.style.height = startRect.height + 'px';
                                            flyingImg.style.transition = 'all 0.7s cubic-bezier(.6,-0.28,.74,.05)';
                                            flyingImg.style.pointerEvents = 'none';
                                            document.body.appendChild(flyingImg);

                                            setTimeout(() => {
                                                flyingImg.style.left = (endRect.left + endRect.width / 2 - startRect.width / 2) + 'px';
                                                flyingImg.style.top = (endRect.top + endRect.height / 2 - startRect.height / 2) + 'px';
                                                flyingImg.style.width = '24px';
                                                flyingImg.style.height = '24px';
                                                flyingImg.style.opacity = 0.5;
                                            }, 10);

                                            setTimeout(() => {
                                                flyingImg.remove();
                                                cartCard.style.display = 'block';
                                                cartCard.classList.add('show');
                                            }, 700);
                                        }

                                        // --- Cart Dropdown Toggle ---
                                        cartBtn.addEventListener('click', function() {
                                            cartCard.classList.toggle('show');
                                            cartCard.style.display = cartCard.classList.contains('show') ? 'block' : 'none';
                                        });

                                        // --- Hide cart dropdown if click outside ---
                                        document.addEventListener('mousedown', function(e) {
                                            if (!cartDropdownWrapper.contains(e.target)) {
                                                cartCard.classList.remove('show');
                                                cartCard.style.display = 'none';
                                            }
                                        });

                                        // --- Setup product events (qty & add to cart) ---
                                        window.setupProductEvents = function() {
                                            document.querySelectorAll('.product-item').forEach(product => {
                                                const minusBtn = product.querySelector('.quantity-left-minus');
                                                const plusBtn = product.querySelector('.quantity-right-plus');
                                                const qtyInput = product.querySelector('input[name="quantity"]');

                                                if (qtyInput && minusBtn && plusBtn) {
                                                    minusBtn.addEventListener('click', function(e) {
                                                        e.preventDefault();
                                                        let currentQty = parseInt(qtyInput.value) || 1;
                                                        if (currentQty > 1) {
                                                            qtyInput.value = currentQty - 1;
                                                        }
                                                    });

                                                    plusBtn.addEventListener('click', function(e) {
                                                        e.preventDefault();
                                                        let currentQty = parseInt(qtyInput.value) || 1;
                                                        qtyInput.value = currentQty + 1;
                                                    });

                                                    qtyInput.addEventListener('input', function() {
                                                        this.value = this.value.replace(/[^0-9]/g, '');
                                                        if (this.value === '' || parseInt(this.value) < 1) {
                                                            this.value = 1;
                                                        }
                                                    });
                                                }

                                                // Add to Cart button
                                                const addToCartBtn = product.querySelector('.add-to-cart-btn');
                                                if (addToCartBtn) {
                                                    addToCartBtn.addEventListener('click', function(e) {
                                                        e.preventDefault();
                                                        const baseUrl = document.querySelector('meta[name="base-url"]')
                                                            .content;
                                                        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
                                                        if (!isAuthenticated) {
                                                            const returnUrl = encodeURIComponent(window.location.href);
                                                            window.location.href = `${baseUrl}/login?redirect=${returnUrl}`;
                                                            return;
                                                        }
                                                        const name = product.querySelector('h3').textContent.trim();
                                                        const price = parseInt(product.querySelector('.price').textContent
                                                            .replace(/[^0-9]/g, ''));
                                                        const desc = product.querySelector('.qty')?.textContent || '';
                                                        const img = product.querySelector('img');
                                                        const qtyInput = product.querySelector('input[name="quantity"]');
                                                        let qty = parseInt(qtyInput?.value) || 1;

                                                        // Add to cart (increase qty if exists)
                                                        let found = cart.find(item => item.name === name);
                                                        if (found) {
                                                            found.qty += qty;
                                                        } else {
                                                            cart.push({
                                                                name,
                                                                price,
                                                                desc,
                                                                qty
                                                            });
                                                        }
                                                        updateCartDropdown();

                                                        // Animate image to cart
                                                        const imgRect = img.getBoundingClientRect();
                                                        const cartRect = cartBtn.getBoundingClientRect();
                                                        animateToCart(img, imgRect, cartRect);
                                                    });
                                                }
                                            });
                                        };
                                    });
                                </script>

                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <meta name="base-url" content="{{ url('/') }}">
                                <!-- / product-grid -->

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5">
                <div class="col">
                    <div class="card mb-3 border-0">
                        <div class="row">
                            <div class="col-md-2 text-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M21.5 15a3 3 0 0 0-1.9-2.78l1.87-7a1 1 0 0 0-.18-.87A1 1 0 0 0 20.5 4H6.8l-.33-1.26A1 1 0 0 0 5.5 2h-2v2h1.23l2.48 9.26a1 1 0 0 0 1 .74H18.5a1 1 0 0 1 0 2h-13a1 1 0 0 0 0 2h1.18a3 3 0 1 0 5.64 0h2.36a3 3 0 1 0 5.82 1a2.94 2.94 0 0 0-.4-1.47A3 3 0 0 0 21.5 15Zm-3.91-3H9L7.34 6H19.2ZM9.5 20a1 1 0 1 1 1-1a1 1 0 0 1-1 1Zm8 0a1 1 0 1 1 1-1a1 1 0 0 1-1 1Z" />
                                </svg>
                            </div>
                            <div class="col-md-10">
                                <div class="card-body p-0">
                                    <h5>Free delivery</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border-0">
                        <div class="row">
                            <div class="col-md-2 text-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19.63 3.65a1 1 0 0 0-.84-.2a8 8 0 0 1-6.22-1.27a1 1 0 0 0-1.14 0a8 8 0 0 1-6.22 1.27a1 1 0 0 0-.84.2a1 1 0 0 0-.37.78v7.45a9 9 0 0 0 3.77 7.33l3.65 2.6a1 1 0 0 0 1.16 0l3.65-2.6A9 9 0 0 0 20 11.88V4.43a1 1 0 0 0-.37-.78ZM18 11.88a7 7 0 0 1-2.93 5.7L12 19.77l-3.07-2.19A7 7 0 0 1 6 11.88v-6.3a10 10 0 0 0 6-1.39a10 10 0 0 0 6 1.39Zm-4.46-2.29l-2.69 2.7l-.89-.9a1 1 0 0 0-1.42 1.42l1.6 1.6a1 1 0 0 0 1.42 0L15 11a1 1 0 0 0-1.42-1.42Z" />
                                </svg>
                            </div>
                            <div class="col-md-10">
                                <div class="card-body p-0">
                                    <h5>100% secure payment</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border-0">
                        <div class="row">
                            <div class="col-md-2 text-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M22 5H2a1 1 0 0 0-1 1v4a3 3 0 0 0 2 2.82V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-9.18A3 3 0 0 0 23 10V6a1 1 0 0 0-1-1Zm-7 2h2v3a1 1 0 0 1-2 0Zm-4 0h2v3a1 1 0 0 1-2 0ZM7 7h2v3a1 1 0 0 1-2 0Zm-3 4a1 1 0 0 1-1-1V7h2v3a1 1 0 0 1-1 1Zm10 10h-4v-2a2 2 0 0 1 4 0Zm5 0h-3v-2a4 4 0 0 0-8 0v2H5v-8.18a3.17 3.17 0 0 0 1-.6a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3.17 3.17 0 0 0 1 .6Zm2-11a1 1 0 0 1-2 0V7h2ZM4.3 3H20a1 1 0 0 0 0-2H4.3a1 1 0 0 0 0 2Z" />
                                </svg>
                            </div>
                            <div class="col-md-10">
                                <div class="card-body p-0">
                                    <h5>Quality guarantee</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border-0">
                        <div class="row">
                            <div class="col-md-2 text-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 8.35a3.07 3.07 0 0 0-3.54.53a3 3 0 0 0 0 4.24L11.29 16a1 1 0 0 0 1.42 0l2.83-2.83a3 3 0 0 0 0-4.24A3.07 3.07 0 0 0 12 8.35Zm2.12 3.36L12 13.83l-2.12-2.12a1 1 0 0 1 0-1.42a1 1 0 0 1 1.41 0a1 1 0 0 0 1.42 0a1 1 0 0 1 1.41 0a1 1 0 0 1 0 1.42ZM12 2A10 10 0 0 0 2 12a9.89 9.89 0 0 0 2.26 6.33l-2 2a1 1 0 0 0-.21 1.09A1 1 0 0 0 3 22h9a10 10 0 0 0 0-20Zm0 18H5.41l.93-.93a1 1 0 0 0 0-1.41A8 8 0 1 1 12 20Z" />
                                </svg>
                            </div>
                            <div class="col-md-10">
                                <div class="card-body p-0">
                                    <h5>guaranteed savings</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border-0">
                        <div class="row">
                            <div class="col-md-2 text-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M18 7h-.35A3.45 3.45 0 0 0 18 5.5a3.49 3.49 0 0 0-6-2.44A3.49 3.49 0 0 0 6 5.5A3.45 3.45 0 0 0 6.35 7H6a3 3 0 0 0-3 3v2a1 1 0 0 0 1 1h1v6a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-6h1a1 1 0 0 0 1-1v-2a3 3 0 0 0-3-3Zm-7 13H8a1 1 0 0 1-1-1v-6h4Zm0-9H5v-1a1 1 0 0 1 1-1h5Zm0-4H9.5A1.5 1.5 0 1 1 11 5.5Zm2-1.5A1.5 1.5 0 1 1 14.5 7H13ZM17 19a1 1 0 0 1-1 1h-3v-7h4Zm2-8h-6V9h5a1 1 0 0 1 1 1Z" />
                                </svg>
                            </div>
                            <div class="col-md-10">
                                <div class="card-body p-0">
                                    <h5>Daily offers</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-menu">
                        <img class="login-head" src="{{ asset('logo/logo2.png') }}" style="width: 285px;">
                        <div class="social-links mt-5">
                            <ul class="d-flex list-unstyled gap-2">
                                <li>
                                    <a href="#" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M15.12 5.32H17V2.14A26.11 26.11 0 0 0 14.26 2c-2.72 0-4.58 1.66-4.58 4.7v2.62H6.61v3.56h3.07V22h3.68v-9.12h3.06l.46-3.56h-3.52V7.05c0-1.05.28-1.73 1.76-1.73Z" />
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M22.991 3.95a1 1 0 0 0-1.51-.86a7.48 7.48 0 0 1-1.874.794a5.152 5.152 0 0 0-3.374-1.242a5.232 5.232 0 0 0-5.223 5.063a11.032 11.032 0 0 1-6.814-3.924a1.012 1.012 0 0 0-.857-.365a.999.999 0 0 0-.785.5a5.276 5.276 0 0 0-.242 4.769l-.002.001a1.041 1.041 0 0 0-.496.89a3.042 3.042 0 0 0 .027.439a5.185 5.185 0 0 0 1.568 3.312a.998.998 0 0 0-.066.77a5.204 5.204 0 0 0 2.362 2.922a7.465 7.465 0 0 1-3.59.448A1 1 0 0 0 1.45 19.3a12.942 12.942 0 0 0 7.01 2.061a12.788 12.788 0 0 0 12.465-9.363a12.822 12.822 0 0 0 .535-3.646l-.001-.2a5.77 5.77 0 0 0 1.532-4.202Zm-3.306 3.212a.995.995 0 0 0-.234.702c.01.165.009.331.009.488a10.824 10.824 0 0 1-.454 3.08a10.685 10.685 0 0 1-10.546 7.93a10.938 10.938 0 0 1-2.55-.301a9.48 9.48 0 0 0 2.942-1.564a1 1 0 0 0-.602-1.786a3.208 3.208 0 0 1-2.214-.935q.224-.042.445-.105a1 1 0 0 0-.08-1.943a3.198 3.198 0 0 1-2.25-1.726a5.3 5.3 0 0 0 .545.046a1.02 1.02 0 0 0 .984-.696a1 1 0 0 0-.4-1.137a3.196 3.196 0 0 1-1.425-2.673c0-.066.002-.133.006-.198a13.014 13.014 0 0 0 8.21 3.48a1.02 1.02 0 0 0 .817-.36a1 1 0 0 0 .206-.867a3.157 3.157 0 0 1-.087-.729a3.23 3.23 0 0 1 3.226-3.226a3.184 3.184 0 0 1 2.345 1.02a.993.993 0 0 0 .921.298a9.27 9.27 0 0 0 1.212-.322a6.681 6.681 0 0 1-1.026 1.524Z" />
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M23 9.71a8.5 8.5 0 0 0-.91-4.13a2.92 2.92 0 0 0-1.72-1A78.36 78.36 0 0 0 12 4.27a78.45 78.45 0 0 0-8.34.3a2.87 2.87 0 0 0-1.46.74c-.9.83-1 2.25-1.1 3.45a48.29 48.29 0 0 0 0 6.48a9.55 9.55 0 0 0 .3 2a3.14 3.14 0 0 0 .71 1.36a2.86 2.86 0 0 0 1.49.78a45.18 45.18 0 0 0 6.5.33c3.5.05 6.57 0 10.2-.28a2.88 2.88 0 0 0 1.53-.78a2.49 2.49 0 0 0 .61-1a10.58 10.58 0 0 0 .52-3.4c.04-.56.04-3.94.04-4.54ZM9.74 14.85V8.66l5.92 3.11c-1.66.92-3.85 1.96-5.92 3.08Z" />
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z" />
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-outline-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M1.04 17.52q.1-.16.32-.02a21.308 21.308 0 0 0 10.88 2.9a21.524 21.524 0 0 0 7.74-1.46q.1-.04.29-.12t.27-.12a.356.356 0 0 1 .47.12q.17.24-.11.44q-.36.26-.92.6a14.99 14.99 0 0 1-3.84 1.58A16.175 16.175 0 0 1 12 22a16.017 16.017 0 0 1-5.9-1.09a16.246 16.246 0 0 1-4.98-3.07a.273.273 0 0 1-.12-.2a.215.215 0 0 1 .04-.12Zm6.02-5.7a4.036 4.036 0 0 1 .68-2.36A4.197 4.197 0 0 1 9.6 7.98a10.063 10.063 0 0 1 2.66-.66q.54-.06 1.76-.16v-.34a3.562 3.562 0 0 0-.28-1.72a1.5 1.5 0 0 0-1.32-.6h-.16a2.189 2.189 0 0 0-1.14.42a1.64 1.64 0 0 0-.62 1a.508.508 0 0 1-.4.46L7.8 6.1q-.34-.08-.34-.36a.587.587 0 0 1 .02-.14a3.834 3.834 0 0 1 1.67-2.64A6.268 6.268 0 0 1 12.26 2h.5a5.054 5.054 0 0 1 3.56 1.18a3.81 3.81 0 0 1 .37.43a3.875 3.875 0 0 1 .27.41a2.098 2.098 0 0 1 .18.52q.08.34.12.47a2.856 2.856 0 0 1 .06.56q.02.43.02.51v4.84a2.868 2.868 0 0 0 .15.95a2.475 2.475 0 0 0 .29.62q.14.19.46.61a.599.599 0 0 1 .12.32a.346.346 0 0 1-.16.28q-1.66 1.44-1.8 1.56a.557.557 0 0 1-.58.04q-.28-.24-.49-.46t-.3-.32a4.466 4.466 0 0 1-.29-.39q-.2-.29-.28-.39a4.91 4.91 0 0 1-2.2 1.52a6.038 6.038 0 0 1-1.68.2a3.505 3.505 0 0 1-2.53-.95a3.553 3.553 0 0 1-.99-2.69Zm3.44-.4a1.895 1.895 0 0 0 .39 1.25a1.294 1.294 0 0 0 1.05.47a1.022 1.022 0 0 0 .17-.02a1.022 1.022 0 0 1 .15-.02a2.033 2.033 0 0 0 1.3-1.08a3.13 3.13 0 0 0 .33-.83a3.8 3.8 0 0 0 .12-.73q.01-.28.01-.92v-.5a7.287 7.287 0 0 0-1.76.16a2.144 2.144 0 0 0-1.76 2.22Zm8.4 6.44a.626.626 0 0 1 .12-.16a3.14 3.14 0 0 1 .96-.46a6.52 6.52 0 0 1 1.48-.22a1.195 1.195 0 0 1 .38.02q.9.08 1.08.3a.655.655 0 0 1 .08.36v.14a4.56 4.56 0 0 1-.38 1.65a3.84 3.84 0 0 1-1.06 1.53a.302.302 0 0 1-.18.08a.177.177 0 0 1-.08-.02q-.12-.06-.06-.22a7.632 7.632 0 0 0 .74-2.42a.513.513 0 0 0-.08-.32q-.2-.24-1.12-.24q-.34 0-.8.04q-.5.06-.92.12a.232.232 0 0 1-.16-.04a.065.065 0 0 1-.02-.08a.153.153 0 0 1 .02-.06Z" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-2 col-sm-6">
                    <div class="footer-menu">
                        <h5 class="widget-title">Ultras</h5>
                        <ul class="menu-list list-unstyled">
                            <li class="menu-item">
                                <a href="#" class="nav-link">About us</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Conditions </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Our Journals</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Careers</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Affiliate Programme</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Ultras Press</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="footer-menu">
                        <h5 class="widget-title">Customer Service</h5>
                        <ul class="menu-list list-unstyled">
                            <li class="menu-item">
                                <a href="#" class="nav-link">FAQ</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Contact</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Privacy Policy</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Returns & Refunds</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Cookie Guidelines</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Delivery Information</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="footer-menu">
                        <h5 class="widget-title">Customer Service</h5>
                        <ul class="menu-list list-unstyled">
                            <li class="menu-item">
                                <a href="#" class="nav-link">FAQ</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Contact</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Privacy Policy</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Returns & Refunds</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Cookie Guidelines</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="nav-link">Delivery Information</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-menu">
                        <h5 class="widget-title">Subscribe Us</h5>
                        <p>Subscribe to our newsletter to get updates about our grand offers.</p>
                        <form class="d-flex mt-3 gap-0" role="newsletter">
                            <input class="form-control rounded-start rounded-0 bg-light" type="email"
                                placeholder="Email Address" aria-label="Email Address">
                            <button class="btn btn-dark rounded-end rounded-0" type="submit">Subscribe</button>
                        </form>
                    </div>
                </div> --}}

            </div>
        </div>
    </footer>
    <div id="footer-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 copyright">
                    <p>© 2023 Foodmart. All rights reserved.</p>
                </div>
                <div class="col-md-6 credit-link text-start text-md-end">
                    <p>Free HTML Template by <a href="https://templatesjungle.com/">TemplatesJungle</a> Distributed by
                        <a href="https://themewagon">ThemeWagon</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets_frontend/js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets_frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('assets_frontend/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const suggestions = document.getElementById('search-suggestions');

            // Sample suggestion data
            const suggestionList = [
                'Handphone',
                'Laptop',
                'Sepatu Sneakers',
                'Tas Wanita',
                'Kamera DSLR',
                'Jam Tangan',
                'Headphone',
                'Baju Anak',
                'Kulkas',
                'Sepeda'
            ];

            function filterSuggestions(query) {
                if (!query) {
                    return [];
                }
                const lowerQuery = query.toLowerCase();
                return suggestionList.filter(item => item.toLowerCase().includes(lowerQuery));
            }

            function clearSuggestions() {
                suggestions.innerHTML = '';
                suggestions.hidden = true;
                searchInput.setAttribute('aria-expanded', 'false');
            }

            function renderSuggestions(items) {
                suggestions.innerHTML = '';
                if (items.length === 0) {
                    clearSuggestions();
                    return;
                }
                items.forEach((item, index) => {
                    const li = document.createElement('li');
                    li.textContent = item;
                    li.setAttribute('role', 'option');
                    li.tabIndex = 0;
                    li.addEventListener('click', () => {
                        searchInput.value = item;
                        clearSuggestions();
                    });
                    li.addEventListener('keydown', e => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            li.click();
                        }
                    });
                    suggestions.appendChild(li);
                });
                suggestions.hidden = false;
                searchInput.setAttribute('aria-expanded', 'true');
            }

            searchInput.addEventListener('input', e => {
                const filtered = filterSuggestions(e.target.value.trim());
                renderSuggestions(filtered);
            });

            searchInput.addEventListener('blur', () => {
                // Delay to allow click event on suggestions
                setTimeout(clearSuggestions, 150);
            });

            searchInput.addEventListener('focus', e => {
                const filtered = filterSuggestions(e.target.value.trim());
                renderSuggestions(filtered);
            });
        });
    </script>

</body>

</html>
