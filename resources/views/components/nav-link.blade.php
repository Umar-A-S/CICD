@props([
    'href' => '#',
    'menu' => '',
    'icon' => 'fa-circle'
])

<a href="{{ $href }}"
   onclick="switchMenu('{{ $menu }}')"
   id="nav-{{ $menu }}"
   class="nav-item flex items-center gap-3 p-3 rounded-r-md text-sm font-medium text-black hover:bg-lime-100 transition">

    <i class="fa-solid {{ $icon }} w-5 text-center"></i>
    <span>{{ $slot }}</span>
</a>