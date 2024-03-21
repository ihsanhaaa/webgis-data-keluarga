const menuMobileOpen = document.getElementById('menu-mobile-open');
const menuMobileClose = document.getElementById('menu-mobile-close');
const menuMobile = document.getElementById('menu-mobile');

menuMobileOpen.addEventListener('click', () => {
	menuMobile.classList.toggle('menu-opened');
});

menuMobileClose.addEventListener('click', () => {
	menuMobile.classList.toggle('menu-opened');
});

function handleGetFormData() {
	const name = document.getElementById('name').value;
	const email = document.getElementById('email').value;
	const city = document.getElementById('city').value;
	const zipCode = document.getElementById('zip-code').value;
	const status = document.getElementById('status').checked;

	return { name, email, city, zipCode, status };
}

function isNumber(zipCode) {
	const number = parseInt(zipCode);

	return !isNaN(number);
}

function checkboxIsChecked(status) {
	return status;
}

function validateFormData(formData) {
	console.log(typeof formData.zipCode);
	if (
		formData &&
		isNumber(formData.zipCode) &&
		checkboxIsChecked(formData.status)
	) {
		return true;
	}

	return false;
}

function submit() {
	event.preventDefault();
	const warning = document.getElementById('warning');

	const formData = handleGetFormData();

	if (!validateFormData(formData)) {
		warning.innerHTML = 'Periksa form anda sekali lagi';
	} else {
		warning.innerHTML = '';
	}
}

document.getElementById('form').addEventListener('submit', () => submit());

const profileNavbar = document.getElementById('profile-navbar');
const btnNavbar = document.getElementById('btn-navbar');
const btnDesktopNavbar = document.querySelector('.btn-desktop-navbar');
const profileDesktopNavbar = document.querySelector('.profile-desktop-navbar');
const profileOption = document.getElementById('profile-option');

profileDesktopNavbar.addEventListener('click', () => {
	profileOption.classList.toggle('hidden');
});

function checkIsLoggedIn() {
	const isLoggedIn = localStorage.getItem('isUserLoggedIn');
	if (isLoggedIn) {
		btnNavbar.classList.add('hidden');
		profileNavbar.classList.remove('hidden');
		profileNavbar.classList.add('flex');
		profileDesktopNavbar.classList.remove('hidden');
		btnDesktopNavbar.classList.add('hidden');
	} else {
		profileNavbar.classList.remove('flex');
		profileNavbar.classList.add('hidden');
		btnNavbar.classList.remove('hidden');
		btnDesktopNavbar.classList.remove('hidden');
		profileDesktopNavbar.classList.add('hidden');
	}
}

checkIsLoggedIn();

const logout = document.getElementById('logout');
logout.addEventListener('click', () => {
	localStorage.clear();
	window.location.href = '';
});
