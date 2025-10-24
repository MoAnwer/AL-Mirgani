<style>
    /* Cards Grid Layout */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 5px;
    }
</style>

<div class="cards-grid">
    {{ $slot }}
</div>