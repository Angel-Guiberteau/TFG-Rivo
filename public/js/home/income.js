document.addEventListener("DOMContentLoaded", function () {
    const scheduleIncomeCheckbox = document.getElementById("scheduleIncome");
    const recurrenceContainerIncome = document.querySelector(".recurrence-container-income");

    const scheduleEgressCheckbox = document.getElementById("scheduleEgress");
    const recurrenceContainerEgress = document.querySelector(".recurrence-container-egress");

    function toggleRecurrenceContainer(checkbox, container) {
        if (checkbox && container) {
            if (checkbox.checked) {
                container.style.display = "block";
            } else {
                container.style.display = "none";
            }
        }
    }

    if (scheduleIncomeCheckbox && recurrenceContainerIncome) {
        scheduleIncomeCheckbox.addEventListener("change", function () {
            toggleRecurrenceContainer(scheduleIncomeCheckbox, recurrenceContainerIncome);
        });

        toggleRecurrenceContainer(scheduleIncomeCheckbox, recurrenceContainerIncome);
    }

    if (scheduleEgressCheckbox && recurrenceContainerEgress) {
        scheduleEgressCheckbox.addEventListener("change", function () {
            toggleRecurrenceContainer(scheduleEgressCheckbox, recurrenceContainerEgress);
        });

        toggleRecurrenceContainer(scheduleEgressCheckbox, recurrenceContainerEgress);
    }
});
