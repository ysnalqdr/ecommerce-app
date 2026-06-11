<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TokoKu — Shop Beyond Boundaries</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php use Illuminate\Support\Facades\Storage; @endphp
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --black: #0f0f0f;
            --white: #ffffff;
            --gray-light: #f5f5f5;
            --gray-mid: #e0e0e0;
            --gray-text: #6b6b6b;
            --red: #e53e3e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--white);
            color: var(--black);
            overflow-x: hidden;
        }

        /* Page loader */
        #page-loader {
            position: fixed;
            inset: 0;
            background: var(--black);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loader-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 64px;
            color: white;
            letter-spacing: 4px;
            animation: loaderPulse 1s ease infinite alternate;
        }
        @keyframes loaderPulse {
            from { opacity: 0.3; transform: scale(0.97); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal.hidden-up {
            opacity: 0;
            transform: translateY(-30px);
        }

        .stagger-children > * {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .stagger-children.visible > *:nth-child(1) { opacity:1; transform:none; transition-delay:0.05s; }
        .stagger-children.visible > *:nth-child(2) { opacity:1; transform:none; transition-delay:0.1s; }
        .stagger-children.visible > *:nth-child(3) { opacity:1; transform:none; transition-delay:0.15s; }
        .stagger-children.visible > *:nth-child(4) { opacity:1; transform:none; transition-delay:0.2s; }
        .stagger-children.visible > *:nth-child(5) { opacity:1; transform:none; transition-delay:0.25s; }
        .stagger-children.visible > *:nth-child(6) { opacity:1; transform:none; transition-delay:0.3s; }
        .stagger-children.visible > *:nth-child(7) { opacity:1; transform:none; transition-delay:0.35s; }
        .stagger-children.visible > *:nth-child(8) { opacity:1; transform:none; transition-delay:0.4s; }
        .stagger-children.visible > *:nth-child(9) { opacity:1; transform:none; transition-delay:0.45s; }
        .stagger-children.visible > *:nth-child(10) { opacity:1; transform:none; transition-delay:0.5s; }
        .stagger-children.visible > *:nth-child(11) { opacity:1; transform:none; transition-delay:0.55s; }
        .stagger-children.visible > *:nth-child(12) { opacity:1; transform:none; transition-delay:0.6s; }

        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* Navbar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--gray-mid);
        }

        .search-input {
            background: var(--gray-light);
            border: none;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            outline: none;
            width: 100%;
            transition: background 0.2s;
            color: var(--black);
        }
        .search-input:focus { background: #ebebeb; }
        .search-input::placeholder { color: #aaa; }

        /* Product Card */
        .product-card {
            cursor: pointer;
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .product-card:hover { transform: translateY(-6px); }
        .product-card:active { transform: scale(0.97); }

        .product-img {
            overflow: hidden;
            background: var(--gray-light);
        }
        .product-img img {
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .product-card:hover .product-img img { transform: scale(1.07); }

        /* Horizontal scroll rows */
        .h-scroll {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding-bottom: 8px;
            scroll-snap-type: x proximity;
        }
        .h-scroll::-webkit-scrollbar { display: none; }
        .h-scroll > * { scroll-snap-align: start; }

        /* Category Card */
        .cat-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border-radius: 12px;
            width: 80px;
            height: 80px;
            flex-shrink: 0;
            transition: all 0.25s ease;
            text-decoration: none;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }
        .cat-card-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.35);
            transition: background 0.25s ease;
            z-index: 1;
        }
        .cat-card:hover .cat-card-overlay { background: rgba(0,0,0,0.55); }
        .cat-card-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .cat-card-bg {
            position: absolute;
            inset: 0;
            background: var(--black);
        }
        .cat-card-text {
            position: relative;
            z-index: 2;
            font-size: 10px;
            color: white;
            font-weight: 600;
            text-align: center;
            line-height: 1.2;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.3px;
            padding: 0 4px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }
        .cat-card:hover { transform: scale(1.05); }

        /* Badge */
        .badge-discount {
            position: absolute;
            top: 8px;
            right: 8px;
            background: var(--red);
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            z-index: 10;
            font-family: 'Inter', sans-serif;
        }
        .badge-mall {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--black);
            color: white;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            z-index: 10;
            letter-spacing: 0.5px;
            font-family: 'Inter', sans-serif;
        }
        .badge-local {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #2d6a4f;
            color: white;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            z-index: 10;
            letter-spacing: 0.5px;
            font-family: 'Inter', sans-serif;
        }

        .nav-dropdown:hover .nav-menu { display: block; }

        /* Hero text animation */
        .hero-text-line { overflow: hidden; }
        .hero-text-inner {
            transform: translateY(100%);
            display: block;
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .hero-text-inner.delay-1 { animation-delay: 0.8s; }
        .hero-text-inner.delay-2 { animation-delay: 0.95s; }
        .hero-sub { opacity: 0; animation: fadeIn 0.6s ease 1.3s forwards; }
        .hero-btn { opacity: 0; animation: fadeIn 0.6s ease 1.5s forwards; }
        .hero-grid { opacity: 0; animation: fadeIn 0.8s ease 0.9s forwards; }

        @keyframes slideUp { to { transform: translateY(0); } }
        @keyframes fadeIn { to { opacity: 1; } }

        @media (max-width: 639px) {
            .hero-grid-wrap { display: none !important; }
            .hero-content { grid-column: span 2; }
        }
    </style>
</head>
<body>

    {{-- Page Loader --}}
    <div id="page-loader">
        <div class="loader-logo">TOKOKU</div>
    </div>
    <script>
        if (sessionStorage.getItem('tokoku_loaded')) {
            document.getElementById('page-loader').style.display = 'none';
        }
    </script>

    {{-- Navbar --}}
    <nav class="navbar">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px;">
            <div style="display:flex; align-items:center; gap:16px; height:56px;">

                <a href="{{ route('home') }}" style="font-family:'Bebas Neue',sans-serif; font-size:22px; color:var(--black); text-decoration:none; flex-shrink:0; letter-spacing:3px;">
                    TOKOKU
                </a>

                <div style="flex:1; max-width:480px; position:relative;">
                    <input type="text" placeholder="Search products, brands, categories..." class="search-input" style="padding-right:36px;">
                    <svg style="position:absolute; right:12px; top:50%; transform:translateY(-50%); width:14px; height:14px; color:#999;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <div style="display:flex; align-items:center; gap:8px; margin-left:auto;">
                    @auth
                        <a href="{{ route('cart.index') }}" style="padding:8px; color:#555; border-radius:8px; display:flex; align-items:center; text-decoration:none; transition:background 0.2s;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">
                            <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </a>
                        <div class="nav-dropdown" style="position:relative;">
                            <button style="display:flex; align-items:center; gap:8px; background:var(--gray-light); border:none; padding:7px 12px; border-radius:8px; cursor:pointer; font-family:'Inter',sans-serif; font-size:13px; font-weight:500; color:var(--black);">
                                <div style="width:24px; height:24px; background:var(--black); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:700;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span>{{ auth()->user()->name }}</span>
                                <svg style="width:12px; height:12px; color:#999;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div class="nav-menu" style="display:none; position:absolute; right:0; top:calc(100% + 8px); width:200px; background:white; border:1px solid var(--gray-mid); border-radius:12px; padding:8px; box-shadow:0 8px 32px rgba(0,0,0,0.1); z-index:100;">
                                <div style="padding:8px 12px 12px; border-bottom:1px solid var(--gray-mid); margin-bottom:4px;">
                                    <p style="font-size:11px; color:#999; margin-bottom:2px;">Signed in as</p>
                                    <p style="font-size:13px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ auth()->user()->name }}</p>
                                </div>
                                <a href="{{ route('order.index') }}" style="display:flex; align-items:center; gap:8px; padding:9px 12px; font-size:13px; color:#333; text-decoration:none; border-radius:8px;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">📦 Pesanan Saya</a>
                                @if(!auth()->user()->sellerProfile)
                                    <a href="{{ route('seller.register') }}" style="display:flex; align-items:center; gap:8px; padding:9px 12px; font-size:13px; color:#333; text-decoration:none; border-radius:8px;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">🏪 Jadi Seller</a>
                                @else
                                    <a href="{{ route('seller.dashboard') }}" style="display:flex; align-items:center; gap:8px; padding:9px 12px; font-size:13px; color:#333; text-decoration:none; border-radius:8px;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">🏪 Toko Saya</a>
                                @endif
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" style="display:flex; align-items:center; gap:8px; padding:9px 12px; font-size:13px; color:#333; text-decoration:none; border-radius:8px;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">⚙️ Admin Panel</a>
                                @endif
                                <div style="border-top:1px solid var(--gray-mid); margin-top:4px; padding-top:4px;">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" style="display:flex; align-items:center; gap:8px; width:100%; padding:9px 12px; font-size:13px; color:#e53e3e; background:none; border:none; cursor:pointer; border-radius:8px; font-family:'Inter',sans-serif;" onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='transparent'">🚪 Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" style="font-size:13px; font-weight:500; color:#555; text-decoration:none; padding:7px 12px; border-radius:8px; transition:background 0.2s;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">Sign In</a>
                        <a href="{{ route('register') }}" style="font-size:13px; font-weight:600; color:white; background:var(--black); text-decoration:none; padding:7px 16px; border-radius:8px;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero (terang/putih) --}}
    <section style="background:var(--white); color:var(--black); overflow:hidden; border-bottom:1px solid var(--gray-mid);">
        <div style="max-width:1280px; margin:0 auto; padding:56px 24px 64px; display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:center;">
            <div class="hero-content">
                <p style="font-size:11px; font-weight:600; letter-spacing:3px; color:#999; margin-bottom:20px; text-transform:uppercase;">May Fashion Sale</p>
                <div>
                    <div class="hero-text-line">
                        <span class="hero-text-inner" style="font-family:'Bebas Neue',sans-serif; font-size:clamp(48px, 6vw, 80px); line-height:0.95; letter-spacing:2px; display:block; color:var(--black);">Limited</span>
                    </div>
                    <div class="hero-text-line">
                        <span class="hero-text-inner delay-1" style="font-family:'Bebas Neue',sans-serif; font-size:clamp(48px, 6vw, 80px); line-height:0.95; letter-spacing:2px; display:block; color:var(--black);">Time Offer!</span>
                    </div>
                    <div class="hero-text-line">
                        <span class="hero-text-inner delay-2" style="font-family:'Bebas Neue',sans-serif; font-size:clamp(48px, 6vw, 80px); line-height:0.95; letter-spacing:2px; color:var(--red); display:block;">Up to 50% OFF!</span>
                    </div>
                </div>
                <p class="hero-sub" style="font-size:14px; color:#777; margin-top:24px; margin-bottom:32px; line-height:1.7; max-width:380px;">Discover premium products from trusted sellers across Indonesia. Shop smarter, live better.</p>
                <div class="hero-btn" style="display:flex; gap:12px; flex-wrap:wrap;">
                    <a href="#produk" style="background:var(--black); color:white; font-size:13px; font-weight:700; padding:13px 32px; border-radius:8px; text-decoration:none; font-family:'Inter',sans-serif; transition:opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">Shop Now</a>
                    @guest
                        <a href="{{ route('register') }}" style="background:transparent; color:var(--black); font-size:13px; font-weight:600; padding:13px 32px; border-radius:8px; text-decoration:none; border:1px solid var(--black); font-family:'Inter',sans-serif; transition:all 0.2s;" onmouseover="this.style.background='var(--black)'; this.style.color='white'" onmouseout="this.style.background='transparent'; this.style.color='var(--black)'">Join Free</a>
                    @endguest
                </div>
            </div>
            <div class="hero-grid hero-grid-wrap" style="display:grid; grid-template-columns:1fr 1fr; gap:8px; border-radius:16px; overflow:hidden; max-height:400px;">
                @foreach($products->take(4) as $p)
                    <div style="background:var(--gray-light); aspect-ratio:1; overflow:hidden; border-radius:8px;">
                        @if($p->primaryImage)
                            <img src="{{ Storage::url($p->primaryImage->image_url) }}" style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:12px;">No Image</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Kategori --}}
    <section style="max-width:1280px; margin:0 auto; padding:48px 24px 0;" class="reveal">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <h2 style="font-family:'Bebas Neue',sans-serif; font-size:28px; letter-spacing:2px; color:var(--black);">All Category</h2>
        </div>
        <div class="scrollbar-hide" style="overflow-x:auto;">
            <div class="stagger-children" style="display:flex; gap:10px; padding-bottom:8px;">
                @foreach($categories as $category)
                    <a href="#produk" class="cat-card">
                        @if($category['image'])
                            <img src="{{ Storage::url($category['image']) }}" class="cat-card-img">
                        @else
                            <div class="cat-card-bg"></div>
                        @endif
                        <div class="cat-card-overlay"></div>
                        <span class="cat-card-text">{{ $category['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Flash Sale --}}
    <section style="max-width:1280px; margin:0 auto; padding:48px 24px 0;" class="reveal">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
            <h2 style="font-family:'Bebas Neue',sans-serif; font-size:28px; letter-spacing:2px; color:var(--black);">⚡ Flash Sale</h2>
            <span style="background:var(--red); color:white; font-size:10px; font-weight:700; padding:3px 8px; border-radius:4px; letter-spacing:1px;">HOT</span>
            <span style="font-size:12px; color:#999; margin-left:auto;">Best deals today</span>
        </div>
        <div class="h-scroll stagger-children">
            @foreach($flashSale as $product)
                <a href="{{ route('product.show', $product->id) }}" class="product-card" style="flex-shrink:0; width:148px;">
                    <div class="product-img" style="height:148px; border-radius:12px; position:relative; margin-bottom:10px;">
                        @if($product->discount_percent > 0)
                            <span class="badge-discount">-{{ $product->discount_percent }}%</span>
                        @endif
                        @if($product->badge === 'official')
                            <span class="badge-mall">MALL</span>
                        @elseif($product->badge === 'local')
                            <span class="badge-local">LOCAL</span>
                        @endif
                        @if($product->primaryImage)
                            <img src="{{ Storage::url($product->primaryImage->image_url) }}" style="width:100%; height:100%; object-fit:cover; border-radius:12px; display:block;">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#bbb; font-size:11px; border-radius:12px;">No Image</div>
                        @endif
                    </div>
                    <p style="font-size:12px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; margin-bottom:3px;">{{ $product->name }}</p>
                    <p style="font-size:13px; font-weight:700; color:var(--red);">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    @if($product->original_price)
                        <p style="font-size:11px; color:#bbb; text-decoration:line-through;">Rp{{ number_format($product->original_price, 0, ',', '.') }}</p>
                    @endif
                    @if($product->total_sold > 0)
                        <p style="font-size:11px; color:#999; margin-top:2px;">{{ $product->total_sold >= 1000 ? number_format($product->total_sold/1000, 1).'rb' : $product->total_sold }} sold</p>
                    @endif
                </a>
            @endforeach
        </div>
    </section>

    {{-- Rekomendasi --}}
    @auth
        @if($recommendations->isNotEmpty())
            <section style="max-width:1280px; margin:0 auto; padding:48px 24px 0;" class="reveal">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
                    <h2 style="font-family:'Bebas Neue',sans-serif; font-size:28px; letter-spacing:2px; color:var(--black);">Todays For You</h2>
                    <span style="font-size:11px; color:#999; background:#f5f5f5; padding:4px 10px; border-radius:20px;">Based on your activity</span>
                </div>
                <div class="h-scroll stagger-children">
                    @foreach($recommendations as $product)
                        <a href="{{ route('product.show', $product->id) }}" class="product-card" style="flex-shrink:0; width:148px;">
                            <div class="product-img" style="height:148px; border-radius:12px; position:relative; margin-bottom:10px;">
                                @if($product->discount_percent > 0)
                                    <span class="badge-discount">-{{ $product->discount_percent }}%</span>
                                @endif
                                @if($product->badge === 'official')
                                    <span class="badge-mall">MALL</span>
                                @elseif($product->badge === 'local')
                                    <span class="badge-local">LOCAL</span>
                                @endif
                                @if($product->primaryImage)
                                    <img src="{{ Storage::url($product->primaryImage->image_url) }}" style="width:100%; height:100%; object-fit:cover; border-radius:12px; display:block;">
                                @else
                                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#bbb; font-size:11px; border-radius:12px;">No Image</div>
                                @endif
                            </div>
                            <p style="font-size:12px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; margin-bottom:3px;">{{ $product->name }}</p>
                            <p style="font-size:13px; font-weight:700; color:var(--black);">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            @if($product->original_price)
                                <p style="font-size:11px; color:#bbb; text-decoration:line-through;">Rp{{ number_format($product->original_price, 0, ',', '.') }}</p>
                            @endif
                            @if($product->total_sold > 0)
                                <p style="font-size:11px; color:#999; margin-top:2px;">{{ $product->total_sold >= 1000 ? number_format($product->total_sold/1000, 1).'rb' : $product->total_sold }} sold</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    @endauth

    {{-- New Arrivals (horizontal scroll) --}}
    <section id="produk" style="max-width:1280px; margin:0 auto; padding:48px 24px 64px;" class="reveal">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
            <h2 style="font-family:'Bebas Neue',sans-serif; font-size:28px; letter-spacing:2px; color:var(--black);">New Arrivals</h2>
            <span style="font-size:12px; color:#999;">{{ $products->count() }} products</span>
        </div>
        <div class="h-scroll stagger-children">
            @foreach($products as $product)
                <a href="{{ route('product.show', $product->id) }}" class="product-card" style="flex-shrink:0; width:190px;">
                    <div class="product-img" style="height:230px; border-radius:14px; position:relative; margin-bottom:12px;">
                        @if($product->discount_percent > 0)
                            <span class="badge-discount">-{{ $product->discount_percent }}%</span>
                        @endif
                        @if($product->badge === 'official')
                            <span class="badge-mall">MALL</span>
                        @elseif($product->badge === 'local')
                            <span class="badge-local">LOCAL</span>
                        @endif
                        @if($product->primaryImage)
                            <img src="{{ Storage::url($product->primaryImage->image_url) }}" style="width:100%; height:100%; object-fit:cover; border-radius:14px; display:block;">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#bbb; font-size:12px; border-radius:14px;">No Image</div>
                        @endif
                    </div>
                    <p style="font-size:13px; font-weight:600; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; margin-bottom:5px;">{{ $product->name }}</p>
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <p style="font-size:14px; font-weight:700;">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        @if($product->original_price)
                            <p style="font-size:11px; color:#bbb; text-decoration:line-through;">Rp{{ number_format($product->original_price, 0, ',', '.') }}</p>
                        @endif
                    </div>
                    @if($product->total_sold > 0)
                        <p style="font-size:11px; color:#999; margin-top:4px;">{{ $product->total_sold >= 1000 ? number_format($product->total_sold/1000, 1).'rb' : $product->total_sold }} sold</p>
                    @endif
                </a>
            @endforeach
        </div>
    </section>

    {{-- Quote --}}
    <section style="background:var(--black); padding:64px 24px; text-align:center;" class="reveal">
        <p style="font-size:12px; font-weight:600; letter-spacing:3px; color:#555; margin-bottom:16px; text-transform:uppercase;">Our Promise</p>
        <h2 style="font-family:'Bebas Neue',sans-serif; font-size:clamp(28px, 5vw, 56px); color:white; letter-spacing:2px; line-height:1.1;">"Let's Shop Beyond Boundaries"</h2>
        <p style="color:#555; font-size:13px; margin-top:12px; letter-spacing:0.5px;">TokoKu — Your trusted marketplace</p>
    </section>

    {{-- Footer (gelap) --}}
    <footer style="background:var(--black); padding:56px 24px;" class="reveal">
        <div style="max-width:1280px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:40px; margin-bottom:48px;">
            <div>
                <p style="font-family:'Bebas Neue',sans-serif; font-size:20px; letter-spacing:3px; margin-bottom:12px; color:white;">TOKOKU</p>
                <p style="font-size:12px; color:#888; line-height:1.8;">Platform belanja online terpercaya dengan ribuan produk pilihan dari seller terbaik.</p>
            </div>
            <div>
                <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; margin-bottom:16px; color:#ccc;">Layanan</p>
                <ul style="list-style:none; display:flex; flex-direction:column; gap:10px;">
                    <li><a href="#" style="font-size:13px; color:#888; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">Bantuan</a></li>
                    <li><a href="{{ route('order.index') }}" style="font-size:13px; color:#888; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">Lacak Pesanan</a></li>
                    <li><a href="#" style="font-size:13px; color:#888; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">Pengembalian</a></li>
                </ul>
            </div>
            <div>
                <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; margin-bottom:16px; color:#ccc;">Seller</p>
                <ul style="list-style:none; display:flex; flex-direction:column; gap:10px;">
                    <li><a href="{{ route('seller.register') }}" style="font-size:13px; color:#888; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">Daftar Seller</a></li>
                    <li><a href="#" style="font-size:13px; color:#888; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">Panduan</a></li>
                </ul>
            </div>
            <div>
                <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; margin-bottom:16px; color:#ccc;">Follow Us</p>
                <ul style="list-style:none; display:flex; flex-direction:column; gap:10px;">
                    <li><a href="#" style="font-size:13px; color:#888; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">Instagram</a></li>
                    <li><a href="#" style="font-size:13px; color:#888; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">Twitter</a></li>
                    <li><a href="#" style="font-size:13px; color:#888; text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">Facebook</a></li>
                </ul>
            </div>
        </div>
        <div style="border-top:1px solid #222; padding-top:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; max-width:1280px; margin:0 auto;">
            <p style="font-size:12px; color:#555;">© {{ date('Y') }} TokoKu. All rights reserved.</p>
            <p style="font-size:12px; color:#555;">Made with ❤️ in Indonesia</p>
        </div>
    </footer>

    <script>
        window.addEventListener('load', () => {
            if (!sessionStorage.getItem('tokoku_loaded')) {
                setTimeout(() => {
                    document.getElementById('page-loader').classList.add('hidden');
                    sessionStorage.setItem('tokoku_loaded', 'true');
                }, 1200);
            }
        });

        const reveals = document.querySelectorAll('.reveal, .stagger-children');
        const prevY = new Map();

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const el = entry.target;
                const currentY = entry.boundingClientRect.top;
                const prev = prevY.get(el) ?? currentY;
                const scrollingDown = currentY < prev;
                prevY.set(el, currentY);

                if (entry.isIntersecting) {
                    el.classList.add('visible');
                    el.classList.remove('hidden-up');
                } else {
                    if (!scrollingDown) {
                        el.classList.remove('visible');
                        el.classList.add('hidden-up');
                        setTimeout(() => {
                            el.classList.remove('hidden-up');
                        }, 300);
                    }
                }
            });
        }, { threshold: 0.08 });

        reveals.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight) {
                el.classList.add('visible');
            } else {
                observer.observe(el);
            }
        });
    </script>

</body>
</html>