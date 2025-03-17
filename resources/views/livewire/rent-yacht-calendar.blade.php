<div x-data="yachtAvailability()" class="w-full p-4 bg-white shadow-lg rounded-[1rem] box-border">
    <h3 class="text-center m-0">Jiné termíny</h3>
    <div class="flex justify-between items-center mb-4">
        <button 
            @click="previousMonth" 
            :disabled="isFirstMonth"
            class="secondary p-2 text-grey-13 text-16 font-semibold capitalize duration-200 border-none"
            :class="{ 'opacity-50 cursor-not-allowed': isFirstMonth }"
        >
            ← Zpět
        </button>

        <h3 class="text-lg font-semibold" x-text="currentMonthName + ' ' + currentYear"></h3>

        <button 
            @click="nextMonth" 
            :disabled="isLastMonth"
            class="secondary p-2 text-grey-13 text-16 font-semibold capitalize duration-200 border-none"
            :class="{ 'opacity-50 cursor-not-allowed': isLastMonth }"
        >
            Další →
        </button>
    </div>

    <template x-if="filteredOffers.length === 0">
        <p class="text-gray-500 text-center">Loď tento měsíc není dostupná.</p>
    </template>

    <div class="grid grid-cols-4 gap-2">
        <template x-for="offer in filteredOffers" :key="offer.dateFrom">
            <a 
                id="dynamic-link"
                :href="generateUrl(new Date(offer.dateFrom), new Date(offer.dateTo))"
                class="border py-4 rounded text-center bg-blue-100 shadow-sm gap-2 flex flex-col"
            >
                <p class="text-sm font-semibold m-0" x-text="formatPrice(offer.price, offer.currency)"></p>
                <p class="text-xs text-gray-700 m-0">
                    <span x-text="formatDate(offer.dateFrom)"></span> - 
                    <span x-text="formatDate(offer.dateTo)"></span>
                </p>
            </a>
        </template>
    </div>
</div>

<script>
    function yachtAvailability() {
        // Parse the `startDate` from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const startDateParam = urlParams.get('startDate');

        // Initialize `currentMonth` and `currentYear` based on `startDate`
        let initialDate;
        if (startDateParam) {
            const [month, day, year] = startDateParam.split('/').map(Number);
            initialDate = new Date(year, month - 1, day); // Months are 0-based in JavaScript
        } else {
            initialDate = new Date(); // Default to the current date
        }

        return {
            currentMonth: initialDate.getMonth() + 1, // Months are 1-based in your logic
            currentYear: initialDate.getFullYear(),
            offers: @json($availabilityData),

            get currentMonthName() {
                return new Date(this.currentYear, this.currentMonth - 1, 1).toLocaleString('default', { month: 'long' });
            },

            get filteredOffers() {
                return this.offers.filter(offer => {
                    let offerDate = new Date(offer.dateFrom);
                    return offerDate.getMonth() + 1 === this.currentMonth && offerDate.getFullYear() === this.currentYear;
                });
            },

            get minMonth() {
                let minDate = this.offers.length ? new Date(Math.min(...this.offers.map(o => new Date(o.dateFrom)))) : new Date();
                return { year: minDate.getFullYear(), month: minDate.getMonth() + 1 };
            },

            get maxMonth() {
                let maxDate = this.offers.length ? new Date(Math.max(...this.offers.map(o => new Date(o.dateFrom)))) : new Date();
                return { year: maxDate.getFullYear(), month: maxDate.getMonth() + 1 };
            },

            get isFirstMonth() {
                return this.currentYear === this.minMonth.year && this.currentMonth === this.minMonth.month;
            },

            get isLastMonth() {
                return this.currentYear === this.maxMonth.year && this.currentMonth === this.maxMonth.month;
            },

            generateUrl(dateFrom, dateTo) {
                const formatDate = (date) => {
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const year = date.getFullYear();
                    return `${month}/${day}/${year}`;
                };

                const baseUrl = window.location.origin + window.location.pathname;
                const startDateParam = formatDate(dateFrom);
                const endDateParam = formatDate(dateTo);
                return `${baseUrl}?startDate=${encodeURIComponent(startDateParam)}&endDate=${encodeURIComponent(endDateParam)}`;
            },

            previousMonth() {
                if (!this.isFirstMonth) {
                    if (this.currentMonth === 1) {
                        this.currentMonth = 12;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                }
            },

            nextMonth() {
                if (!this.isLastMonth) {
                    if (this.currentMonth === 12) {
                        this.currentMonth = 1;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                }
            },

            formatPrice(price, currency) {
                return new Intl.NumberFormat('cz-CZ', { style: 'currency', currency: currency }).format(price);
            },

            formatDate(date) {
                return new Date(date).toLocaleDateString('cs-CZ', { day: '2-digit', month: 'short' });
            }
        };
    }
</script>