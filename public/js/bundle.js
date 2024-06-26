let SPECIAL_DATES = null;

(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
	SPECIAL_DATES = require('festivos-colombia');
},{"festivos-colombia":2}],2:[function(require,module,exports){
/**
 * Modulo que contiene la lógica para obtener los Días festivos
 * @module calendar
 * @author Juan Bermudez <juanbermucele@hotmail.com>
 * @since 1.0
 */
const HOLIDAYS = require("./holidays.js").holidays;

/**
 * @function applyTwoDigits
 * Aplica el formato de dos d├¡gitos a un número menor que diez
 * @author Juan Bermudez <juanbermucele@hotmail.com>
 * @since 1.0
 * @param {number} number 
 * @returns {string} texto formateado
 */
function applyTwoDigits(number) {
	return number < 10 ? "0" + number : number;
}

/**
 * @function formatDate
 * Aplica el formato DD/MM/YYYY a una fecha
 * @author Juan Bermudez <juanbermucele@hotmail.com>
 * @since 1.0
 * @param {Date} date objeto con la fecha a formatear
 * @returns {string} texto de la fecha formateada
 */
function formatDate(date) {
	return applyTwoDigits(date.getDate()) + "/" + applyTwoDigits(date.getMonth() + 1) + "/" + date.getFullYear();
}

/**
 * @function getEasterSunday
 * Algoritmo propuesto por Ian Stewart en 2001 para calcular la fecha
 * exacta del domingo de resurrección/pascua
 * @author Juan Bermudez <juanbermucele@hotmail.com>
 * @since 1.0
 * @param {number} year número del Año
 * @returns {Date} Retorna el domingo de resurrección/pascua
 */
function getEasterSunday(year) {
	let a, b, c, d, e, day;
	a = year % 19;
	b = year % 4;
	c = year % 7;
	d = (19 * a + 24) % 30;
	e = (2 * b + 4 * c + 6 * d + 5) % 7;
	day = 22 + d + e;

	if (day >= 1 && day <= 31) {
		return new Date(`03/${applyTwoDigits(day)}/${year}`);
	} else {
		return new Date(`04/${applyTwoDigits(day - 31)}/${year}`);
	}
}

/**
 * @function getNextMonday
 * Calcula el próximo lunes de una fecha dada
 * @author Juan Bermudez <juanbermucele@hotmail.com>
 * @since 1.0
 * @param {Date} date fecha de partida
 * @returns {Date} retorna el próximo lunes a la fecha
 */
function getNextMonday(date) {
	//console.log("Fecha recibida: " + date.toDateString());
	while (date.getDay() !== 1) {
		date.setDate(date.getDate() + 1);
		//console.log("New date: " + date);
	}
	return date;
}

/**
 * @function sumDay
 * Suma una cantidad de Días a una fecha dada
 * @author Juan Bermudez <juanbermucele@hotmail.com>
 * @since 1.0
 * @param {string} stringDate objeto de la fecha
 * @param {number} dayToSum cantidad de Días a sumar
 * @returns {Date} retorna la nueva fecha con los Días sumados
 */
function sumDay(stringDate, dayToSum) {
	let date = new Date(stringDate);
	date.setDate(date.getDate() + dayToSum);
	return date;
}

/**
 * @function getHolidaysByYear
 * Calcula y retorna el listado de festivos de un Año dado
 * @author Juan Bermudez <juanbermucele@hotmail.com>
 * @since 1.0
 * @param {number} year número del Año
 * @returns {Array} Array con todos los festivos del Año
 */
function getHolidaysByYear(year) {
	let holidaysArray = [];
	//Obtiene el domingo de pascua para calcular los Días litúrgicos
	let easterSunday = getEasterSunday(year);

	HOLIDAYS.forEach(element => {
		let date;
		if (!element.daysToSum) {
			date = new Date(element.date + "/" + year);
		} else {
			date = sumDay(easterSunday.toDateString(), element.daysToSum);
		}

		if (element.nextMonday) {
			date = getNextMonday(date);
		}
		holidaysArray.push({
			date: formatDate(date),
			name: element.name,
			static: element.nextMonday
		});
	});
	return holidaysArray;
}

/**
 * @function getHolidaysByYear
 * Calcula todos los Días festivos de un rango de Años
 * @author Juan Bermudez <juanbermucele@hotmail.com>
 * @since 1.0
 * @param {*} initialYear Año de inicio del rango
 * @param {*} finalYear Año final del rango
 * @returns {Array} Array con todos los festivos del Año
 */
function getHolidaysByYearInterval(initialYear, finalYear) {
	let holidaysArray = [];
	//Obtiene el domingo de pascua para calcular los Días litúrgicos
	for (let i = initialYear; i <= finalYear; i++) {
		let year = {
			year : i,
			holidays: []
		};
		let easterSunday = getEasterSunday(i);

		HOLIDAYS.forEach(element => {
			let date;
			if (!element.daysToSum) {
				date = new Date(element.date + "/" + i);
			} else {
				date = sumDay(easterSunday.toDateString(), element.daysToSum);
			}

			if (element.nextMonday) {
				date = getNextMonday(date);
			}
			year.holidays.push({
				date: formatDate(date),
				name: element.name,
				static: element.nextMonday
			});
		});
		holidaysArray.push(year);
	}
	return holidaysArray;
}

/**
 * @function isHoliday
 * Calcula si un dia en especifico es festivo
 * @author Santiago Alarcón <salarconlagos@gmail.com>
 * @since 1.0.1
 * @param {Date} date Fecha que se busca saber si es o no festivo.
 * @returns {Boolean} Booleano que indica si es o no es festivo.
 */

function isHoliday(date) {
	return !!getHolidaysByYear(date.getFullYear()).find((holiday) => {
		return holiday.date == formatDate(date);
	})
}

module.exports.getHolidaysByYear = getHolidaysByYear;
module.exports.getHolidaysByYearInterval = getHolidaysByYearInterval;
module.exports.isHoliday = isHoliday;
},{"./holidays.js":3}],3:[function(require,module,exports){
const HOLIDAYS = [
	{ date: "01/01", nextMonday: false, name: "Año Nuevo" },
	{ date: "01/06", nextMonday: true, name: "Día de los Reyes Magos" },
	{ date: "03/19", nextMonday: true, name: "Día de San José" },
	{ daysToSum: -3, nextMonday: false, name: "Jueves Santo" },
	{ daysToSum: -2, nextMonday: false, name: "Viernes Santo" },
	{ date: "05/01", nextMonday: false, name: "Día del Trabajo" },
	{ daysToSum: 40, nextMonday: true, name: "Ascensión del Señor" },
	{ daysToSum: 60, nextMonday: true, name: "Corphus Christi" },
	{ daysToSum: 71, nextMonday: true, name: "Sagrado Corazón de Jesús" },
	{ date: "06/29", nextMonday: true, name: "San Pedro y San Pablo" },
	{ date: "07/20", nextMonday: false, name: "Día de la Independencia" },
	{ date: "08/07", nextMonday: false, name: "Batalla de Boyacá" },
	{ date: "08/15", nextMonday: true, name: "La Asunción de la Virgen" },
	{ date: "10/12", nextMonday: true, name: "Día de la Raza" },
	{ date: "11/01", nextMonday: true, name: "Todos los Santos" },
	{ date: "11/11", nextMonday: true, name: "Independencia de Cartagena" },
	{ date: "12/08", nextMonday: false, name: "Día de la Inmaculada Concepción" },
	{ date: "12/25", nextMonday: false, name: "Día de Navidad" }
];

/**
 * Modulo que contiene dos Objetos con las fechas de los Días 
 * festivos del Año
 * @module holidays
 */
exports.holidays = HOLIDAYS;
/* 
pascua entre marzo 22 y abril 25
ascensión 40 Días después de pascua
corpus christi 60 Días después de pascua
sagrado corazon 71 Días después de pascua
*/
},{}]},{},[1]);
