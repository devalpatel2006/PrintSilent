{{-- JSON-LD Structured Data Component --}}
{{-- Renders all schema.org JSON-LD scripts for the current page --}}

@if(!empty($seo['schemas']))
    @foreach($seo['schemas'] as $schema)
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
    @endforeach
@endif
