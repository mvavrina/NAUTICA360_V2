<div class="p-4 max-w-[700px]">
        <!-- Heading -->
        <h2 class="text-primary mb-0">Napište nám</h2>

        <!-- Text -->
        <p class="mb-8 mt-2">Dolore magna aliqua enim ad minim veniam, quis nostrudreprehenderits
            dolore fugiat nulla pariatur lorem ipsum dolor sit amet.</p>
        <img src="{{asset('img/vlny-gold.svg')}}" class="mb-8" alt="Vlny icon">

        <!-- Form -->
        <form class="grid grid-cols-1 md:grid-cols-2 gap-6 gap-x-8 box-content">
            <!-- Name -->
            <input type="text" placeholder="Name" class="custom-input">
            <!-- Surname -->
            <input type="text" placeholder="Surname" class="custom-input">
            <!-- Email -->
            <input type="email" placeholder="Email" class="custom-input">
            <!-- Phone -->
            <input type="tel" placeholder="Phone" class="custom-input">
            <!-- Subject (Full Width) -->
            <input type="text" placeholder="Subject" class="custom-input md:col-span-2">
            <!-- Message (Full Width) -->
            <textarea placeholder="Message" rows="4" class="custom-input md:col-span-2"></textarea>

            <!-- Button (Full Width) -->
            <div class="flex">
                <x-button style="primary" text="Odeslat" class="md:col-span-2" />
            </div>
        </form>
</div>
