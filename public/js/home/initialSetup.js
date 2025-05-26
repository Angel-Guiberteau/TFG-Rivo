document.addEventListener('DOMContentLoaded', function () {
    const titleInfo = document.getElementById('infoTitle');
    const description = document.getElementById('description');
    const title = document.getElementById('title');
    const subtitle = document.getElementById('subtitle');
    const firstStepFields = [
        document.getElementById('name'),
        document.getElementById('last_name'),
        document.getElementById('username'),
        document.getElementById('birth_date')
    ];
    const firstStepButton = document.getElementById('next1');

    const secondStepFields = [
        document.getElementById('salary'),
        document.getElementById('familyHelp'),
        document.getElementById('stateHelp'),
    ];
    const firsStepButton = document.getElementById('next1');

    const sectionFirstStep = document.getElementById('firstStep');
    const sectionSecondStep = document.getElementById('secondStep');
    const sectionThirdStep = document.getElementById('thirdStep');
    const sectionFourthStep = document.getElementById('fourthStep');
    const sectionFifthStep = document.getElementById('fifthStep');
    const sectionSixthStep = document.getElementById('sixthStep');
    const sectionSeventhStep = document.getElementById('seventhStep');
    const sectionEighthStep = document.getElementById('eighthStep');
    const sectionNinthStep = document.getElementById('ninthStep');
    const sectionTenthStep = document.getElementById('tenthStep');

    

    const salaryIncome = document.getElementById('salary');
    const familyHelpIncome = document.getElementById('familyHelp');
    const stateHelpIncome = document.getElementById('stateHelp');
    const homeExpenses = document.getElementById('homeExpenses');
    const servicesHomeExpenses = document.getElementById('servicesHomeExpenses');
    const feedingExpenses = document.getElementById('feedingExpenses');
    const transportationExpenses = document.getElementById('transportationExpenses');
    const healthExpenses = document.getElementById('healthExpenses');
    const telephoneExpenses = document.getElementById('telephoneExpenses');
    const educationExpenses = document.getElementById('educationExpenses');
    const otherExpenses = document.getElementById('otherExpenses');
    const freeMoney = document.getElementById('freeMoney');

    const percentage1 = document.getElementById('percentage1');
    const percentage2 = document.getElementById('percentage2');
    const percentage3 = document.getElementById('percentage3');
    const personalizePercentage = document.getElementById('personalizePercentage');
    const labelPercentage1 = document.getElementById('labelPercentage1');
    const labelPercentage2 = document.getElementById('labelPercentage2');
    const labelPercentage3 = document.getElementById('labelPercentage3');
    
    let inputAvaibleSaveMoney = document.getElementById('avaibleSaveMoney');

    const objEmergency = document.getElementById('objEmergency');
    const objDebt = document.getElementById('objDebt');
    const objSave = document.getElementById('objSave');
    const personalizeObjective = document.getElementById('objPersonalize');


    let avaibleMoneyToVariableExpenses = document.querySelectorAll('.avaibleMoneyToVariableExpenses');

    let fixedIncome;
    let fixedExpenses;
    let choosedPercentage;
    let saveMoney;
    let suggestion;
    let freeMoneyOriginal;

    window.validateFirstStep = function (){
        const allFilled = firstStepFields.every(input => input.value.trim() != '');
        firstStepButton.disabled = !allFilled;
    }
    window.validateSecondStep = function (){
        const allFilled = firsStepFields.every(input => input.value.trim() != '');
        firsStepButton.disabled = !allFilled;
    }
    flatpickr("#birth_date", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d-m-Y",
        locale: "es",
        maxDate: "today",
        altInputClass: "custom-flatpickr",
        onReady: function (selectedDates, dateStr, instance) {
            instance.altInput.placeholder = "Selecciona una fecha";
        }
    });

    const progressBar = document.getElementById('progressBar');

    function updateProgress(percent) {
        progressBar.style.width = `${percent}%`;
        progressBar.setAttribute('aria-valuenow', percent);
    }
    
    function showCursor(element) {
        element.classList.add('typewriter-cursor');
    }

    function hideCursor(element) {
        element.classList.remove('typewriter-cursor');
    }

    function typeWriter(element, text, speed = 30) {
        element.textContent = '';
        showCursor(element);
        let i = 0;
        function typing() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(typing, speed);
            } else {
                hideCursor(element);
            }
        }
        typing();
    }

    function typeWriterReplace(element, newText, speed = 30) {
        const eraseSpeed = 2;
        const oldText = element.textContent;
        let j = oldText.length;

        showCursor(element);

        function erase() {
            if (j > 0) {
                element.textContent = oldText.substring(0, j - 1);
                j--;
                setTimeout(erase, eraseSpeed);
            } else {
                typeWriter(element, newText, speed);
            }
        }

        erase();
    }

    function calculateAvaibleFreeMoney() {
        const inputs = document.querySelectorAll('.variableExpense');
        let total = 0;

        inputs.forEach(input => {
            let val = parseFloat(input.value);

            if (isNaN(val) || val < 0) {
                input.value = '';
                val = 0;
            }

            if (total + val > freeMoneyOriginal) {
                const maxPermitido = freeMoneyOriginal - total;
                input.value = maxPermitido.toFixed(2);
                total = freeMoneyOriginal;
            } else {
                total += val;
            }
        });

        return total;
    }
    window.updateAvaibleMoney = function () {
        const totalGastos = calculateAvaibleFreeMoney();
        const disponible = freeMoneyOriginal - totalGastos;

        avaibleMoneyToVariableExpenses.forEach(span => {
            span.innerText = disponible.toFixed(2) + ' €';
        });
    }

    function animateSectionChange(hideSection, showSection) {
        hideSection.classList.add('d-none');
        showSection.classList.remove('d-none');
    }

    function adviseToSaveMoney(freeMoney) {
        let theSuggestion;
        const calculateAmounts = (percentages) => ({
            min: +(freeMoney * (percentages.min / 100)).toFixed(2),
            mid: +(freeMoney * (percentages.mid / 100)).toFixed(2),
            max: +(freeMoney * (percentages.max / 100)).toFixed(2),
        });

        if (freeMoney <= 49) {
            const percentage = { min: 0, mid: 2.5, max: 5 };
            theSuggestion = {
                percentage,
                amount: calculateAmounts(percentage),
                message: "Ahora mismo tu prioridad es estabilizar tus gastos. Puedes empezar con algo simbólico."
            };
        } else if (freeMoney <= 99) {
            const percentage = { min: 5, mid: 7.5, max: 10 };
            theSuggestion = {
                percentage,
                amount: calculateAmounts(percentage),
                message: "Podrías empezar con un pequeño hábito de ahorro. Lo importante es la constancia."
            };
        } else if (freeMoney <= 199) {
            const percentage = { min: 10, mid: 12.5, max: 15 };
            theSuggestion = {
                percentage,
                amount: calculateAmounts(percentage),
                message: "Es un buen momento para crear un ahorro regular sin que afecte tu día a día."
            };
        } else if (freeMoney <= 299) {
            const percentage = { min: 15, mid: 17.5, max: 20 };
            theSuggestion = {
                percentage,
                amount: calculateAmounts(percentage),
                message: "Ya tienes un margen cómodo. Un ahorro moderado te hará avanzar rápido."
            };
        } else if (freeMoney <= 499) {
            const percentage = { min: 20, mid: 22.5, max: 25 };
            theSuggestion = {
                percentage,
                amount: calculateAmounts(percentage),
                message: "Puedes plantearte un ahorro más ambicioso sin descuidar tus gastos variables."
            };
        } else if (freeMoney <= 799) {
            const percentage = { min: 25, mid: 27.5, max: 30 };
            theSuggestion = {
                percentage,
                amount: calculateAmounts(percentage),
                message: "¡Muy buen margen! Este nivel te permite ahorrar con fuerza y planificar a medio plazo."
            };
        } else if (freeMoney <= 1199) {
            const percentage = { min: 30, mid: 32.5, max: 35 };
            theSuggestion = {
                percentage,
                amount: calculateAmounts(percentage),
                message: "Estás en una excelente posición para alcanzar metas importantes."
            };
        } else {
            const percentage = { min: 35, mid: 37.5, max: 40 };
            theSuggestion = {
                percentage,
                amount: calculateAmounts(percentage),
                message: "Tienes una gran capacidad de ahorro. Aprovechémosla para metas ambiciosas."
            };
        }

        return theSuggestion;
    }

    window.clearRadios = function (){
        percentage1.checked = false;
        percentage2.checked = false;
        percentage3.checked = false;
    }

    window.clearRadiosS6 = function (){
        objEmergency.checked = false;
        objSave.checked = false;
        objDebt.checked = false;
    }

    window.whatPercentage = function(inputNumber){
        if(inputNumber !=4){            
            personalizePercentage.value = '';
        }
        choosedPercentage = inputNumber;
    }

    window.clearPersonalizeObj = function(){
        personalizeObjective.value = ''
    }

    window.previousStep = function (currentStep) {
        switch (currentStep) {
            case 2:
                animateSectionChange(sectionSecondStep, sectionFirstStep);
                typeWriterReplace(title, '¡Empecemos!');
                typeWriterReplace(subtitle, 'Cuéntanos un poco sobre ti para ayudarte mejor.', 1);
                titleInfo.innerHTML = 'Configuración inicial'
                description.innerHTML = 'Un poco de información sobre ti para poder conocerte mejor.';
                updateProgress(0);
                break;
            case 3:
                animateSectionChange(sectionThirdStep, sectionSecondStep);
                typeWriterReplace(title, 'Ingresos fijos');
                typeWriterReplace(subtitle, '¿Cuánto ganas al mes normalmente?', 1);
                updateProgress(20);
                description.innerHTML = 'Indícanos tus ingresos mensuales fijos. Si no recibes dinero por alguno de los conceptos, simplemente déjalo en blanco. Esto nos ayuda a conocer tu punto de partida.';
                break;
            case 4:
                animateSectionChange(sectionFourthStep, sectionThirdStep);
                typeWriterReplace(title, 'Gastos fijos');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes?', 1);
                description.innerHTML = 'Vamos a ver en qué se te va el dinero cada mes. Estos son tus gastos fijos principales. Si alguno no aplica, puedes dejarlo vacío.<br>Recuerda: lo ideal es que tus gastos no superen tus ingresos.';
                updateProgress(30);
                break;
            case 5:
                animateSectionChange(sectionFifthStep, sectionFourthStep);
                typeWriterReplace(title, 'Gastos fijos');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes?', 1);
                description.innerHTML = 'Aquí tienes los últimos gastos fijos a tener en cuenta. Después pasaremos a los gastos variables.<br>Importante: tus gastos totales no deberían superar tus ingresos mensuales.';
                updateProgress(40);
                break;
            case 6:
                animateSectionChange(sectionSixthStep, sectionFifthStep);
                typeWriterReplace(title, 'Dinero libre');
                typeWriterReplace(subtitle, 'Usaremos el dinero libre para conseguir ahorrar', 1);
                description.innerHTML = 'Este es el dinero que te queda disponible cada mes después de cubrir tus gastos fijos. A partir de aquí, podemos definir cuánto ahorrar. Si ahora mismo estás justo, puedes poner 0 %, pero recuerda: incluso una pequeña cantidad puede marcar la diferencia.';
                updateProgress(50);
                break;
            case 7:
                animateSectionChange(sectionSeventhStep, sectionSixthStep);
                typeWriterReplace(title, 'Objetivo actual');
                typeWriterReplace(subtitle, 'Marquemos un objetivo a corto/medio plazo', 1);
                description.innerHTML = 'Establecer un objetivo claro te ayudará a mantenerte motivado y a dar sentido a tu ahorro mensual. Elige el que mejor se adapte a ti o crea uno personalizado.';
                updateProgress(60);
                break;
            case 8:
                animateSectionChange(sectionEighthStep, sectionSeventhStep);
                typeWriterReplace(title, 'Gastos Variables');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes?', 1);
                description.innerHTML = 'Ahora veremos tus gastos variables: aquellos que pueden cambiar cada mes. No tienen por qué ser exactos, pero te servirán como guía para controlar tus hábitos de consumo.';
                updateProgress(70);
                break;
            case 9:
                animateSectionChange(sectionNinthStep, sectionEighthStep);
                typeWriterReplace(title, 'Gastos Variables');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes?', 1);
                description.innerHTML = 'Estos son los últimos gastos variables. Tenerlos identificados te ayudará a saber cuánto puedes recortar si necesitas ahorrar más en algún momento.';
                updateProgress(80);
                break;
            case 10:
                animateSectionChange(sectionTenthStep, sectionNinthStep);
                typeWriterReplace(title, 'Ahorro actual');
                typeWriterReplace(subtitle, '¿Cuánto tienes ahorrado actualmente?', 1);
                description.innerHTML = '¿Tienes algún dinero ahorrado ya? Si es así, ¡enhorabuena! Y si no, no pasa nada: lo importante es que estás dando el primer paso para empezar a construirlo.';
                updateProgress(90);
                break;
        }
    };


    window.nextStep = function (currentStep) {
        switch (currentStep) {
            case 1:
                animateSectionChange(sectionFirstStep, sectionSecondStep);
                typeWriterReplace(title, 'Ingresos fijos');
                typeWriterReplace(subtitle, '¿Cuánto ganas al mes normalmente? Esto nos ayuda a entender tu punto de partida.', 1);
                description.innerHTML = 'Indícanos tus ingresos mensuales fijos. Si no recibes dinero por alguno de los conceptos, simplemente déjalo en blanco. Esto nos ayuda a conocer tu punto de partida.';

                updateProgress(20);
                break;
            case 2:
                fixedIncome = Number(salaryIncome.value || 0) + Number(stateHelpIncome.value || 0) + Number(familyHelpIncome.value || 0);

                animateSectionChange(sectionSecondStep, sectionThirdStep);
                typeWriterReplace(title, 'Gastos fijos');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes? Veamos juntos tus gastos fijos.', 1); 
                description.innerHTML = 'Vamos a ver en qué se te va el dinero cada mes. Estos son tus gastos fijos principales. Si alguno no aplica, puedes dejarlo vacío.<br>Recuerda: lo ideal es que tus gastos no superen tus ingresos.';
                updateProgress(30);
                
                break;
            case 3:
                animateSectionChange(sectionThirdStep, sectionFourthStep);
                typeWriterReplace(title, 'Gastos fijos');
                typeWriterReplace(subtitle, 'Otros gastos fijos', 1); 
                description.innerHTML = 'Aquí tienes los últimos gastos fijos a tener en cuenta. Después pasaremos a los gastos variables.<br>Importante: tus gastos totales no deberían superar tus ingresos mensuales.';
                updateProgress(40);
                break;
            case 4:
                fixedExpenses = Number(homeExpenses.value || 0) + Number(otherExpenses.value || 0) + Number(healthExpenses.value || 0) + Number(feedingExpenses.value || 0) + Number(educationExpenses.value || 0) + Number(telephoneExpenses.value || 0) + Number(servicesHomeExpenses.value || 0) + Number(transportationExpenses.value || 0);
                
                freeMoney.value = fixedIncome - fixedExpenses;
                
                suggestion = adviseToSaveMoney(freeMoney.value);
            
                percentage1.value = Number(suggestion.percentage.min);
                percentage2.value = Number(suggestion.percentage.mid);
                percentage3.value = Number(suggestion.percentage.max);
                labelPercentage1.innerHTML = suggestion.percentage.min + '% - ' + suggestion.amount.min +'€';
                labelPercentage2.innerHTML = suggestion.percentage.mid + '% - ' + suggestion.amount.mid +'€';
                labelPercentage3.innerHTML = suggestion.percentage.max + '% - ' + suggestion.amount.max +'€';
                animateSectionChange(sectionFourthStep, sectionFifthStep);
                typeWriterReplace(title, 'Dinero libre');
                typeWriterReplace(subtitle, suggestion.message , 1); 
                description.innerHTML = 'Este es el dinero que te queda disponible cada mes después de cubrir tus gastos fijos. A partir de aquí, podemos definir cuánto ahorrar. Si ahora mismo estás justo, puedes poner 0 %, pero recuerda: incluso una pequeña cantidad puede marcar la diferencia.';
                updateProgress(50);
                break;
            case 5:
                if(choosedPercentage === 1){
                    saveMoney = suggestion.amount.min;
                }else{
                    if(choosedPercentage == 2){
                        saveMoney = suggestion.amount.mid;
                    }else{
                        if(choosedPercentage == 3){
                            saveMoney = suggestion.amount.max;
                        }else{
                            saveMoney = personalizePercentage.value * freeMoney.value / 100;
                        }
                    }
                }
                inputAvaibleSaveMoney.value = Number(saveMoney);

                animateSectionChange(sectionFifthStep, sectionSixthStep);
                typeWriterReplace(title, 'Objetivo actual');
                typeWriterReplace(subtitle, 'Marquemos un objetivo a corto/medio plazo', 1); 
                description.innerHTML = 'Establecer un objetivo claro te ayudará a mantenerte motivado y a dar sentido a tu ahorro mensual. Elige el que mejor se adapte a ti o crea uno personalizado.';
                updateProgress(60);
                break;
            case 6:
                freeMoneyOriginal = Number(freeMoney.value) - saveMoney;
                avaibleMoneyToVariableExpenses.forEach(span => {
                    span.innerText = freeMoneyOriginal.toFixed(2) + ' €';
                });

                animateSectionChange(sectionSixthStep, sectionSeventhStep);
                typeWriterReplace(title, 'Gastos Variables');
                typeWriterReplace(subtitle, 'Usaremos el dinero libre para ver cuanto deberiamos gastar', 1); 
                description.innerHTML = 'Ahora veremos tus gastos variables: aquellos que pueden cambiar cada mes. No tienen por qué ser exactos, pero te servirán como guía para controlar tus hábitos de consumo.';
                updateProgress(70);
                break;
            case 7:
                animateSectionChange(sectionSeventhStep, sectionEighthStep);
                typeWriterReplace(title, 'Gastos Variables');
                typeWriterReplace(subtitle, 'Usaremos el dinero libre para ver cuanto deberiamos gastar', 1); 
                description.innerHTML = 'Estos son los últimos gastos variables. Tenerlos identificados te ayudará a saber cuánto puedes recortar si necesitas ahorrar más en algún momento.';
                updateProgress(80);
                break;
            case 8:
                animateSectionChange(sectionEighthStep, sectionNinthStep);
                typeWriterReplace(title, 'Ahorro actual');
                typeWriterReplace(subtitle, '¿Cuánto tienes ahorrado actualmente?', 1); 
                description.innerHTML = '¿Tienes algún dinero ahorrado ya? Si es así, ¡enhorabuena! Y si no, no pasa nada: lo importante es que estás dando el primer paso para empezar a construirlo.';
                updateProgress(90);
                break;
            case 9:
                animateSectionChange(sectionNinthStep, sectionTenthStep);
                typeWriterReplace(title, 'Primera cuenta');
                typeWriterReplace(subtitle, '¿Qué nombre le pondrás a tu cuenta?', 1); 
                description.innerHTML = 'Ponle un nombre a tu primera cuenta. Será tu base para organizar y gestionar tu dinero a partir de ahora. ¡Enhorabuena por llegar hasta aquí!';
                updateProgress(100);
                break;
        }
    };
});
