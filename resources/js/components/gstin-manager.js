export default function gstinManager() {
    return {
        gstin: '',
        formattedGstin: '',
        isValid: false,
        errorMessage: '',
        stateCode: '',
        stateName: '',

        states: {
            '01': 'Jammu and Kashmir',
            '02': 'Himachal Pradesh',
            '03': 'Punjab',
            '04': 'Chandigarh',
            '05': 'Uttarakhand',
            '06': 'Haryana',
            '07': 'Delhi',
            '08': 'Rajasthan',
            '09': 'Uttar Pradesh',
            '10': 'Bihar',
            '11': 'Sikkim',
            '12': 'Arunachal Pradesh',
            '13': 'Nagaland',
            '14': 'Manipur',
            '15': 'Mizoram',
            '16': 'Tripura',
            '17': 'Meghalaya',
            '18': 'Assam',
            '19': 'West Bengal',
            '20': 'Jharkhand',
            '21': 'Odisha',
            '22': 'Chhattisgarh',
            '23': 'Madhya Pradesh',
            '24': 'Gujarat',
            '25': 'Daman and Diu',
            '26': 'Dadra and Nagar Haveli and Daman and Diu',
            '27': 'Maharashtra',
            '28': 'Andhra Pradesh',
            '29': 'Karnataka',
            '30': 'Goa',
            '31': 'Lakshadweep',
            '32': 'Kerala',
            '33': 'Tamil Nadu',
            '34': 'Puducherry',
            '35': 'Andaman and Nicobar Islands',
            '36': 'Telangana',
            '37': 'Andhra Pradesh (New)',
            '38': 'Ladakh'
        },

        init() {
            this.$watch('gstin', (value) => {
                this.handleGSTINInput(value);
            });
        },

        handleGSTINInput(value) {
            if (!value) {
                this.resetValidation();
                return;
            }

            const cleanValue = value.toUpperCase().replace(/[^A-Z0-9]/g, '');

            this.gstin = cleanValue.substring(0, 15);
            this.formattedGstin = this.formatGSTIN(this.gstin);

            this.validateGSTIN();
        },

        formatGSTIN(gstin) {
            if (gstin.length <= 2) return gstin;

            const parts = [
                gstin.substring(0, 2),
                gstin.substring(2, 12),
                gstin.substring(12, 13),
                gstin.substring(13, 14),
                gstin.substring(14, 15)
            ];

            return parts.filter(Boolean).join(' ');
        },

        validateGSTIN() {
            const gstinRegex =
                /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;

            if (this.gstin.length !== 15) {
                this.isValid = false;
                this.errorMessage = 'GSTIN must be 15 characters';
                return;
            }

            if (!gstinRegex.test(this.gstin)) {
                this.isValid = false;
                this.errorMessage = 'Invalid GSTIN format';
                return;
            }

            this.isValid = true;
            this.errorMessage = '';

            this.extractState();
        },

        extractState() {
            this.stateCode = this.gstin.substring(0, 2);
            this.stateName = this.states[this.stateCode] || 'Unknown State';
        },

        resetValidation() {
            this.isValid = false;
            this.errorMessage = '';
            this.formattedGstin = '';
            this.stateCode = '';
            this.stateName = '';
        },

        get validationIcon() {
            if (!this.gstin) return '';

            return this.isValid ? '✓' : '✗';
        },

        get validationClass() {
            if (!this.gstin) return '';

            return this.isValid
                ? 'text-green-600'
                : 'text-red-600';
        }
    };
}