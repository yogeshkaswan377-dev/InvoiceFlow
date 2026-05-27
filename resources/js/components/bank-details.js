export default function bankDetails() {
    return {
        accounts: [
            {
                bank_name: '',
                account_number: '',
                holder_name: '',
                ifsc: '',
                branch: '',
                upi_id: '',
                is_default: true
            }
        ],

        addAccount() {
            this.accounts.push({
                bank_name: '',
                account_number: '',
                holder_name: '',
                ifsc: '',
                branch: '',
                upi_id: '',
                is_default: false
            });
        },

        removeAccount(index) {
            if (confirm('Are you sure you want to delete this account?')) {
                this.accounts.splice(index, 1);

                if (this.accounts.length > 0 &&
                    !this.accounts.some(acc => acc.is_default)) {
                    this.accounts[0].is_default = true;
                }
            }
        },

        setDefault(index) {
            this.accounts.forEach((account, i) => {
                account.is_default = i === index;
            });
        },

        validateIFSC(ifsc) {
            const regex = /^[A-Z]{4}0[A-Z0-9]{6}$/;

            return regex.test(ifsc.toUpperCase());
        }
    };
}