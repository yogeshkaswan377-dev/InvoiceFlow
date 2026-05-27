export default function fileUpload() {
    return {
        file: null,
        preview: null,
        progress: 0,
        dragOver: false,
        error: '',
        allowedTypes: [
            'image/jpeg',
            'image/png',
            'image/svg+xml'
        ],

        maxSizes: {
            logo: 2 * 1024 * 1024,
            signature: 1 * 1024 * 1024
        },

        handleDrop(event, type = 'logo') {
            this.dragOver = false;

            const file = event.dataTransfer.files[0];

            this.processFile(file, type);
        },

        handleFileSelect(event, type = 'logo') {
            const file = event.target.files[0];

            this.processFile(file, type);
        },

        processFile(file, type) {
            this.error = '';

            if (!file) return;

            if (!this.allowedTypes.includes(file.type)) {
                this.error = 'Invalid file type';
                return;
            }

            if (file.size > this.maxSizes[type]) {
                this.error = `File size exceeds limit`;
                return;
            }

            this.file = file;

            this.generatePreview(file);

            this.simulateProgress();
        },

        generatePreview(file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.preview = e.target.result;
            };

            reader.readAsDataURL(file);
        },

        simulateProgress() {
            this.progress = 0;

            const interval = setInterval(() => {
                this.progress += 10;

                if (this.progress >= 100) {
                    clearInterval(interval);
                }
            }, 100);
        }
    };
}