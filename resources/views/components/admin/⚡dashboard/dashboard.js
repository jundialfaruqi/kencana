let livewireSearchQueryInput;
let searchButton;
let html5QrCode = null;

function loadScannerLibrary(callback) {
    if (window.Html5Qrcode) {
        callback();
        return;
    }
    const script = document.createElement('script');
    script.src = "https://unpkg.com/html5-qrcode";
    script.async = true;
    script.onload = callback;
    script.onerror = () => {
        const status = document.getElementById('scanner-status');
        if (status) {
            status.textContent = 'Gagal memuat library scanner';
        }
    };
    document.head.appendChild(script);
}

function playBeepSound() {
    try {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);

        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // A5 note
        gainNode.gain.setValueAtTime(0.15, audioCtx.currentTime);
        
        oscillator.start();
        setTimeout(() => {
            oscillator.stop();
            audioCtx.close();
        }, 120);
    } catch (e) {
        console.error("Failed to play beep sound", e);
    }
}

function fillBookingCode(fullCode) {
    const match = fullCode.match(/BK-(\d{4})(\d{2})(\d{2})-(.{4})/i);
    if (!match) return false;

    const year = match[1];
    const month = match[2];
    const day = match[3];
    const code = match[4];

    const inputYear1 = document.getElementById('input-year-1');
    const inputYear2 = document.getElementById('input-year-2');
    const inputYear3 = document.getElementById('input-year-3');
    const inputYear4 = document.getElementById('input-year-4');
    const inputMonth1 = document.getElementById('input-month-1');
    const inputMonth2 = document.getElementById('input-month-2');
    const inputDay1 = document.getElementById('input-day-1');
    const inputDay2 = document.getElementById('input-day-2');
    const inputCode1 = document.getElementById('input-code-1');
    const inputCode2 = document.getElementById('input-code-2');
    const inputCode3 = document.getElementById('input-code-3');
    const inputCode4 = document.getElementById('input-code-4');

    const inputSegments = [
        inputYear1, inputYear2, inputYear3, inputYear4,
        inputMonth1, inputMonth2, inputDay1, inputDay2,
        inputCode1, inputCode2, inputCode3, inputCode4,
    ].filter(Boolean);

    if (inputSegments.length === 12) {
        // Fill year inputs
        inputSegments[0].value = year[0];
        inputSegments[1].value = year[1];
        inputSegments[2].value = year[2];
        inputSegments[3].value = year[3];

        // Fill month inputs
        inputSegments[4].value = month[0];
        inputSegments[5].value = month[1];

        // Fill day inputs
        inputSegments[6].value = day[0];
        inputSegments[7].value = day[1];

        // Fill code inputs
        inputSegments[8].value = code[0];
        inputSegments[9].value = code[1];
        inputSegments[10].value = code[2];
        inputSegments[11].value = code[3];

        // Update Livewire search input directly
        const livewireInput = document.getElementById('livewire-search-query-input');
        if (livewireInput) {
            let component = null;
            if (window.Livewire) {
                const root = livewireInput.closest('[wire\\:id]');
                if (root) {
                    const componentId = root.getAttribute('wire:id');
                    component = window.Livewire.find(componentId);
                }
            }

            if (component) {
                // Set value on Livewire model and run the search method directly
                component.set('searchQuery', fullCode.toUpperCase());
                setTimeout(() => {
                    component.call('searchBooking');
                }, 50);
            } else {
                // Fallback: manually update input and trigger event + click button
                livewireInput.value = fullCode.toUpperCase();
                livewireInput.dispatchEvent(new Event('input'));
                const searchButton = document.getElementById('search-button');
                if (searchButton) {
                    setTimeout(() => {
                        searchButton.click();
                    }, 150);
                }
            }
        }
        return true;
    }
    return false;
}

function getFullBookingCode(inputSegments) {
    const inputBkB = document.getElementById('input-bk-b');
    const inputBkK = document.getElementById('input-bk-k');

    if (!inputBkB || !inputBkK) {
        return ''; 
    }

    const bkPart = inputBkB.value + inputBkK.value;
    const datePart = inputSegments.slice(0, 8).map(input => input.value).join('');
    const codePart = inputSegments.slice(8, 12).map(input => input.value).join('');
    const fullCode = `${bkPart}-${datePart}-${codePart}`;
    if (bkPart.length === 2 && datePart.length === 8 && codePart.length === 4) {
        return fullCode;
    }
    return '';
}

function updateLivewireSearchQuery(inputSegments) {
    const fullCode = getFullBookingCode(inputSegments);
    if (livewireSearchQueryInput) {
        livewireSearchQueryInput.value = fullCode;
        livewireSearchQueryInput.dispatchEvent(new Event('input')); // Trigger Livewire update
    }
}

function setInitialFocus(inputSegments) {
    if (inputSegments.length > 0) {
        inputSegments[0].focus();
    }
}

function initializeInputLogic() {
    const inputYear1 = document.getElementById('input-year-1');
    const inputYear2 = document.getElementById('input-year-2');
    const inputYear3 = document.getElementById('input-year-3');
    const inputYear4 = document.getElementById('input-year-4');
    const inputMonth1 = document.getElementById('input-month-1');
    const inputMonth2 = document.getElementById('input-month-2');
    const inputDay1 = document.getElementById('input-day-1');
    const inputDay2 = document.getElementById('input-day-2');
    const inputCode1 = document.getElementById('input-code-1');
    const inputCode2 = document.getElementById('input-code-2');
    const inputCode3 = document.getElementById('input-code-3');
    const inputCode4 = document.getElementById('input-code-4');

    const inputSegments = [
        inputYear1, inputYear2, inputYear3, inputYear4,
        inputMonth1, inputMonth2, inputDay1, inputDay2,
        inputCode1, inputCode2, inputCode3, inputCode4,
    ].filter(Boolean); // Filter out any null elements

    livewireSearchQueryInput = document.getElementById('livewire-search-query-input');
    searchButton = document.getElementById('search-button');

    // Remove existing event listeners to prevent duplicates
    inputSegments.forEach(input => {
        input.removeEventListener('input', handleInput);
        input.removeEventListener('keydown', handleKeydown);
    });

    // Define handlers to be able to remove them later
    function handleInput(e) {
        if (this.value.length > 1) {
            this.value = this.value.slice(0, 1);
        }

        const currentIndex = inputSegments.indexOf(this);
        if (this.value && currentIndex < inputSegments.length - 1) {
            inputSegments[currentIndex + 1].focus();
        }
        updateLivewireSearchQuery(inputSegments);
    }

    function handleKeydown(e) {
        const currentIndex = inputSegments.indexOf(this);
        if (e.key === 'Backspace' && this.value === '' && currentIndex > 0) {
            inputSegments[currentIndex - 1].focus();
        }
        if (e.key === 'Enter') {
            e.preventDefault();
            if (searchButton) {
                searchButton.click(); // Trigger the Livewire search action via button click
            }
        }
    }

    inputSegments.forEach((input) => {
        input.addEventListener('input', handleInput);
        input.addEventListener('keydown', handleKeydown);
    });

    if (inputYear1) {
        inputYear1.addEventListener('paste', (event) => {
            event.preventDefault();
            const pasteData = event.clipboardData.getData('text');
            const success = fillBookingCode(pasteData);
            if (success && searchButton) {
                setTimeout(() => {
                    searchButton.click();
                }, 150);
            }
        });
    }

    // Barcode Scanner Event Binding
    const scanButton = document.getElementById('scan-button');
    const scannerModal = document.getElementById('scanner-modal');
    const closeScannerBtn = document.getElementById('close-scanner-btn');
    const closeScannerBackdrop = document.getElementById('close-scanner-backdrop');
    const scannerStatus = document.getElementById('scanner-status');
    const scannerLaser = document.getElementById('scanner-laser');

    if (scanButton && scannerModal && !scanButton.__bound) {
        scanButton.addEventListener('click', () => {
            scannerModal.classList.remove('hidden');
            scannerStatus.textContent = 'Menghubungkan ke kamera...';
            scannerLaser.classList.add('hidden');

            loadScannerLibrary(() => {
                scannerStatus.textContent = 'Mencari kamera belakang...';
                
                if (!html5QrCode) {
                    const formats = [];
                    if (window.Html5QrcodeSupportedFormats) {
                        formats.push(window.Html5QrcodeSupportedFormats.QR_CODE);
                    }
                    html5QrCode = new Html5Qrcode("reader", {
                        formatsToSupport: formats.length > 0 ? formats : undefined
                    });
                }
                
                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 15,
                        aspectRatio: 1.777778,
                        experimentalFeatures: {
                            useBarCodeDetectorIfSupported: true
                        }
                    },
                    (decodedText, decodedResult) => {
                        playBeepSound();
                        const success = fillBookingCode(decodedText);
                        if (success) {
                            stopScanner();
                        } else {
                            scannerStatus.textContent = 'Barcode tidak valid: ' + decodedText;
                            setTimeout(() => {
                                if (html5QrCode && html5QrCode.isScanning) {
                                    scannerStatus.textContent = 'Pindai barcode booking...';
                                }
                            }, 3000);
                        }
                    },
                    (errorMessage) => {
                        // Scan errors are silent
                    }
                ).then(() => {
                    scannerStatus.textContent = 'Pindai barcode booking...';
                    scannerLaser.classList.remove('hidden');
                }).catch(err => {
                    console.error("Camera access failed", err);
                    scannerStatus.textContent = 'Akses kamera gagal: Pastikan izin kamera aktif';
                });
            });
        });

        function stopScanner() {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    scannerModal.classList.add('hidden');
                    scannerLaser.classList.add('hidden');
                }).catch(err => {
                    console.error("Stop failed", err);
                    scannerModal.classList.add('hidden');
                    scannerLaser.classList.add('hidden');
                });
            } else {
                scannerModal.classList.add('hidden');
                scannerLaser.classList.add('hidden');
            }
        }

        if (closeScannerBtn) {
            closeScannerBtn.addEventListener('click', stopScanner);
        }
        if (closeScannerBackdrop) {
            closeScannerBackdrop.addEventListener('click', stopScanner);
        }
        
        scanButton.__bound = true;
    }

    updateLivewireSearchQuery(inputSegments);
    setInitialFocus(inputSegments);
}

function registerLivewireListeners() {
    if (window.Livewire && !window.__dashboardListenersBound) {
        window.Livewire.on('inputs-ready', () => {
            setTimeout(() => {
                initializeInputLogic(); // Re-initialize after Livewire event
            }, 0); // A small delay to ensure DOM is fully ready
        });
        window.__dashboardListenersBound = true;
    }
}

document.addEventListener('DOMContentLoaded', registerLivewireListeners);
document.addEventListener('livewire:navigated', registerLivewireListeners);
document.addEventListener('livewire:init', registerLivewireListeners);
if (document.readyState !== 'loading') {
    registerLivewireListeners();
}

