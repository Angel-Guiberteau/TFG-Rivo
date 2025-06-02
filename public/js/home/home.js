// HOME JS

window.addEventListener('load', () => {
    const loader = document.getElementById('loader');
    setTimeout(() => {
        loader.style.animation = 'fadeOut 0.6s ease-in-out forwards';
        setTimeout(() => loader.remove(), 600);
    }, 3000);
});

document.querySelectorAll('.action-button').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.action-button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });

    setTimeout(() => {
        const alert = document.querySelector('.rivo-alert');
        if (alert) alert.remove();
    }, 4000);
});

export async function fetchData(url, method = 'GET', body = null) {
    const options = {
        method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    };

    if (body && method !== 'GET') {
        options.body = JSON.stringify(body);
    }

    try {
        const response = await fetch(url, options);

        if (!response.ok) throw new Error(`Error ${response.status}: ${response.statusText}`);

        return await response.json();
    } catch (err) {
        console.error(`Error al hacer fetch a ${url}:`, err);
        return null;
    }
}


