const carList = document.getElementById("car-list");
let cars = [];

const createCar = document.getElementById("add");

createCar.addEventListener('click', () => {
    const marca = document.getElementById('add_marca').value;
    const veiculo = document.getElementById('add_veiculo').value;
    const ano = document.getElementById('add_ano').value;
    const descricao = document.getElementById('add_desc').value;
    const vendido = document.getElementById('add_vendido').value;

    const car = {
        marca,
        veiculo,
        ano,
        descricao,
        vendido: vendido === 'on' ? true : false
    }

    fetch('http://localhost:9501/veiculos', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(car)
    }).then(resp => {
        if (resp.ok) {
            getAll();
        }
    })
})


const search = document.getElementById('busca');

search.addEventListener('keyup', (e) => {
    const query = e.target.value;
    if (e.key === 'Enter') {
        const descricaoContainer = document.getElementById('car-description');
        descricaoContainer.classList.add('hidden')
        find(query);
    }
})

const addCarInfo = (data) => {
    carList.innerHTML = '';
    data.forEach(car => {
        const infoCar = document.createElement('div');
        infoCar.classList.add('container-info-car');
        infoCar.dataset.id = car.id;
        infoCar.innerHTML = `
                <p class="name-brand">${car.marca}</p>
                        <p class="name-car">${car.veiculo}</p>
                        <p class="year-car">${car.ano}</p>
                        <i class="tag bi bi-tag-fill">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-tag-fill" viewBox="0 0 16 16">
                            <path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1H2zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                            </svg>
                        </i>`
        carList.appendChild(infoCar);

        infoCar.addEventListener('click', () => {
            const descricaoContainer = document.getElementById('car-description');
            descricaoContainer.classList.remove('hidden')
            const id = infoCar.dataset.id;
            const car = cars.find(car => car.id == id);

            const descMarca = document.getElementById('marca');
            const descVeiculo = document.getElementById('veiculo');
            const descAno = document.getElementById('ano');
            const descDescricao = document.getElementById('descricao');

            descMarca.innerText = car.marca;
            descVeiculo.innerText = car.veiculo;
            descAno.innerText = car.ano;
            descDescricao.innerText = car.descricao;
        })
    })
}


const getAll = async () => {
    const resp = await fetch('http://localhost:9501/veiculos');
    console.log(resp);
    const data = await resp.json();
    console.log(data);
    cars = data;
    addCarInfo(data);
}

const find = async (query) => {
    const resp = await fetch(`http://localhost:9501/veiculos/find?q=${query}`);
    if (!resp.ok) {
        cars = [];
    } else {
        const data = await resp.json();
        cars = data;
    }
    addCarInfo(cars);
}

document.addEventListener('DOMContentLoaded', () => {
    getAll();
});
