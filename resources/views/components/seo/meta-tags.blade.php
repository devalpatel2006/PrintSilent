{{-- SEO Meta Tags Component --}}
{{-- Renders <title>, meta description, canonical, Open Graph, Twitter Card, and robots --}}

<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}" />
<meta name="keywords" content="{{ $seo['keywords'] }}" />
<meta name="robots" content="{{ $seo['robots'] }}" />
<link rel="canonical" href="{{ $seo['canonical'] }}" />

{{-- Open Graph --}}
<meta property="og:title" content="{{ $seo['title'] }}" />
<meta property="og:description" content="{{ $seo['description'] }}" />
<meta property="og:url" content="{{ $seo['canonical'] }}" />
<meta property="og:image" content="{{ $seo['og_image'] }}" />
<meta property="og:type" content="{{ $seo['og_type'] }}" />
<meta property="og:site_name" content="{{ $seo['site_name'] }}" />
<meta property="og:locale" content="en_US" />

{{-- Twitter Card --}}
<meta name="twitter:card" content="{{ $seo['twitter_card'] }}" />
<meta name="twitter:site" content="{{ $seo['twitter'] }}" />
<meta name="twitter:title" content="{{ $seo['title'] }}" />
<meta name="twitter:description" content="{{ $seo['description'] }}" />
<meta name="twitter:image" content="{{ $seo['og_image'] }}" />
