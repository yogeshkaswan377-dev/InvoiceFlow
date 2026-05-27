export default function gstRatesManager() {
    return {
        rates: [
            {
                rate: '',
                cgst: '',
                sgst: '',
                igst: ''
            }
        ],

        availableRates: [5, 12, 18, 28],

        addRow() {
            this.rates.push({
                rate: '',
                cgst: '',
                sgst: '',
                igst: ''
            });
        },

        removeRow(index) {
            if (this.rates.length === 1) {
                return;
            }

            this.rates.splice(index, 1);
        },

        updateRate(index) {
            const rate = parseFloat(this.rates[index].rate);

            if (!isNaN(rate)) {
                this.rates[index].cgst = rate / 2;
                this.rates[index].sgst = rate / 2;
                this.rates[index].igst = rate;
            }
        },

        get jsonData() {
            return JSON.stringify(this.rates);
        }
    };
}