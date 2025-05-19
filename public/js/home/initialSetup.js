document.addEventListener('DOMContentLoaded', function () {
    const title = document.getElementById('title');
    const subtitle = document.getElementById('subtitle');
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

    function animateSectionChange(hideSection, showSection) {
        hideSection.classList.add('d-none');
        showSection.classList.remove('d-none');
    }

    window.previousStep = function (currentStep) {
        switch (currentStep) {
            case 2:
                animateSectionChange(sectionSecondStep, sectionFirstStep);
                typeWriterReplace(title, '¡Empecemos!');
                typeWriterReplace(subtitle, 'Cuéntanos un poco sobre ti para ayudarte mejor.', 1);
                updateProgress(0);
                break;
            case 3:
                animateSectionChange(sectionThirdStep, sectionSecondStep);
                typeWriterReplace(title, 'Ingresos fijos');
                typeWriterReplace(subtitle, '¿Cuánto ganas al mes normalmente?', 1);
                updateProgress(20);
                break;
            case 4:
                animateSectionChange(sectionFourthStep, sectionThirdStep);
                typeWriterReplace(title, 'Gastos fijos');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes?', 1);
                updateProgress(30);
                break;
            case 5:
                animateSectionChange(sectionFifthStep, sectionFourthStep);
                typeWriterReplace(title, 'Gastos fijos');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes?', 1);
                updateProgress(40);
                break;
            case 6:
                animateSectionChange(sectionSixthStep, sectionFifthStep);
                typeWriterReplace(title, 'Dinero libre');
                typeWriterReplace(subtitle, 'Usaremos el dinero libre para conseguir ahorrar', 1);
                updateProgress(50);
                break;
            case 7:
                animateSectionChange(sectionSeventhStep, sectionSixthStep);
                typeWriterReplace(title, 'Objetivo actual');
                typeWriterReplace(subtitle, 'Marquemos un objetivo a corto/medio plazo', 1);
                updateProgress(60);
                break;
            case 8:
                animateSectionChange(sectionEighthStep, sectionSeventhStep);
                typeWriterReplace(title, 'Gastos Variables');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes?', 1);
                updateProgress(70);
                break;
            case 9:
                animateSectionChange(sectionNinthStep, sectionEighthStep);
                typeWriterReplace(title, 'Gastos Variables');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes?', 1);
                updateProgress(80);
                break;
            case 10:
                animateSectionChange(sectionTenthStep, sectionNinthStep);
                typeWriterReplace(title, 'Ahorro actual');
                typeWriterReplace(subtitle, '¿Cuánto tienes ahorrado actualmente?', 1);
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

                updateProgress(20);
                break;
            case 2:
                animateSectionChange(sectionSecondStep, sectionThirdStep);
                typeWriterReplace(title, 'Gastos fijos');
                typeWriterReplace(subtitle, '¿En qué se va tu dinero cada mes? Veamos juntos tus gastos fijos.', 1); 
                updateProgress(30);
                break;
            case 3:
                animateSectionChange(sectionThirdStep, sectionFourthStep);
                typeWriterReplace(title, 'Gastos fijos');
                typeWriterReplace(subtitle, 'Otros gastos fijos', 1); 
                updateProgress(40);
                break;
            case 4:
                animateSectionChange(sectionFourthStep, sectionFifthStep);
                typeWriterReplace(title, 'Dinero libre');
                typeWriterReplace(subtitle, 'Usaremos el dinero libre para conseguir ahorrar', 1); 
                updateProgress(50);
                break;
            case 5:
                animateSectionChange(sectionFifthStep, sectionSixthStep);
                typeWriterReplace(title, 'Objetivo actual');
                typeWriterReplace(subtitle, 'Marquemos un objetivo a corto/medio plazo', 1); 
                updateProgress(60);
                break;
            case 6:
                animateSectionChange(sectionSixthStep, sectionSeventhStep);
                typeWriterReplace(title, 'Gastos Variables');
                typeWriterReplace(subtitle, 'Usaremos el dinero libre para ver cuanto deberiamos gastar', 1); 
                updateProgress(70);
                break;
            case 7:
                animateSectionChange(sectionSeventhStep, sectionEighthStep);
                typeWriterReplace(title, 'Gastos Variables');
                typeWriterReplace(subtitle, 'Usaremos el dinero libre para ver cuanto deberiamos gastar', 1); 
                updateProgress(80);
                break;
            case 8:
                animateSectionChange(sectionEighthStep, sectionNinthStep);
                typeWriterReplace(title, 'Ahorro actual');
                typeWriterReplace(subtitle, '¿Cuánto tienes ahorrado actualmente?', 1); 
                updateProgress(90);
                break;
            case 9:
                animateSectionChange(sectionNinthStep, sectionTenthStep);
                typeWriterReplace(title, 'Primera cuenta');
                typeWriterReplace(subtitle, '¿Qué nombre le pondrás a tu cuenta?', 1); 
                updateProgress(100);
                break;
        }
    };
});
