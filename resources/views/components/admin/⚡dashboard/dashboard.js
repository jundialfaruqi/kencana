let livewireSearchQueryInput;
let searchButton;

function getFullBookingCode(inputSegments) {
    const inputBkB = document.getElementById('input-bk-b');
    const inputBkK = document.getElementById('input-bk-k');

    if (!inputBkB || !inputBkK) {
        return ''; // Return empty string if elements are not found (e.g., on another page)
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

    inputYear1.addEventListener('paste', (event) => {
        event.preventDefault();
        const pasteData = event.clipboardData.getData('text');
        const match = pasteData.match(/BK-(\d{4})(\d{2})(\d{2})-(.{4})/i);

        if (match) {
            const year = match[1];
            const month = match[2];
            const day = match[3];
            const code = match[4];

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

            updateLivewireSearchQuery(inputSegments);
        }
    });

    updateLivewireSearchQuery(inputSegments);
    setInitialFocus(inputSegments);
}

document.addEventListener('DOMContentLoaded', function () {
    // Register Livewire event listener ONLY ONCE on DOMContentLoaded
    if (window.Livewire) {
        Livewire.on('inputs-ready', () => {
            setTimeout(() => {
                initializeInputLogic(); // Re-initialize after Livewire event
            }, 0); // A small delay to ensure DOM is fully ready
        });
    }
});
