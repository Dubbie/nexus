<script setup></script>

<template>
    <div class="bg-pattern flex min-h-screen flex-col pt-6 sm:pt-0">
        <div>
            <header
                class="flex items-center justify-center px-4 py-6 md:justify-start md:px-20 md:pt-12"
            >
                <div>
                    <p class="select-none text-2xl font-bold tracking-tight">
                        <span class="text-white">Sunday</span>
                        <span class="text-indigo-500">Nexus</span>
                    </p>
                </div>
            </header>
        </div>

        <div
            class="flex w-full max-w-[90vw] flex-1 flex-col items-center justify-center self-center sm:max-w-[80vw] md:max-w-[50vw] lg:max-w-[40vw] xl:max-w-[33vw]"
        >
            <div class="w-full bg-white px-12 py-6 shadow-xl">
                <slot />
            </div>
        </div>

        <div
            class="bg-gradient-to-t from-black/20 to-transparent px-20 pb-12 pt-6 text-white/60"
        >
            <footer class="text-center md:text-left">
                <p class="text-sm font-semibold md:text-xs">
                    Sunday Nexus is the authentication service for Sunday It.
                </p>
            </footer>
        </div>
    </div>
</template>

<style scoped>
.bg-pattern {
    background: linear-gradient(
            135deg,
            #0000 18.75%,
            #27272a 0 31.25%,
            #0000 0
        ),
        repeating-linear-gradient(45deg, #27272a -6.25% 6.25%, #212124 0 18.75%);
    background-size: 80px 80px;
}
</style>
