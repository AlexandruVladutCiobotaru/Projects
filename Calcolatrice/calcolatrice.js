// costanti

const buttons = document.querySelectorAll('.calculator button');
const buttonClear = document.querySelector('#btnClear');
const display = document.querySelector('.display');
const equal = document.querySelector('#equal')

// funzioni

buttons.forEach(button => {
    button.addEventListener('click', () => {
        display.value += button.textContent;
    });
});

buttonClear.addEventListener('click', () => {
    display.value = '';
});

function calcola() {
    const regex = /(\d+)\s*(.)\s*(\d+)/;
    const match = display.value.match(regex);
    const num1 = parseFloat(match[1]);
    const operazione = match[2].trim();
    const num2 = parseFloat(match[3]);

    let risultato;

    switch (operazione) {
        case '+':
            risultato = num1 + num2;
            break;
        case '-':
            risultato = num1 - num2;
            break;
        case '*':
            risultato = num1 * num2;
            break;
        case '/':
            if (num2 != 0) {
                risultato = num1 / num2;
            } else {
               risultato = ('Ehi, hai rotto la calcolatrice!');
            }
            break;
    }

    display.value = risultato;
};

equal.addEventListener('click', calcola);

