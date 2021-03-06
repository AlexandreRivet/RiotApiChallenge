var map = AmCharts.makeChart( "map_region", {

  type: "map",
  "theme": "dark",

  dataProvider: {
    map: "worldLow",
    areas: [ {
        title: "Austria",
        id: "AT",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Ireland",
        id: "IE",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Great Britain",
        id: "GB",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Italy",
        id: "IT",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "France",
        id: "FR",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Spain",
        id: "ES",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Germany",
        id: "DE",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Belgium",
        id: "BE",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Luxembourg",
        id: "LU",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Netherlands",
        id: "NL",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Portugal",
        id: "PT",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Switzerland",
        id: "CH",
        color: "#ff6600",
        customData: "EUW",
        groupId: "EUW"
      }, {
        title: "Greece",
        id: "GR",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Lithuania",
        id: "LT",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Latvia",
        id: "LV",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Czech Republic ",
        id: "CZ",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Slovakia",
        id: "SK",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Slovenia",
        id: "SI",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Estonia",
        id: "EE",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Hungary",
        id: "HU",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Poland",
        id: "PL",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Romania",
        id: "RO",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Bulgaria",
        id: "BG",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Croatia",
        id: "HR",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Bosnia and Herzegovina",
        id: "BA",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"   
      }, {
        title: "Montenegro",
        id: "ME",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Serbia",
        id: "RS",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Kosovo",
        id: "XK",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Albania",
        id: "AL",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Macedonia",
        id: "MK",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Belarus",
        id: "BY",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Ukrania",
        id: "UA",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Moldova",
        id: "MD",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Norway",
        id: "NO",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Sweden",
        id: "SE",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Finland",
        id: "FI",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "Iceland",
        id: "IS",
        color: "#67b7dc",
        customData: "EUNE",
        groupId: "EUNE"
      }, {
        title: "United States",
        id: "US",
        color: "#1abc9c",
        customData: "NA",
        groupId: "NA"
      }, {
        title: "Canada",
        id: "CA",
        color: "#1abc9c",
        customData: "NA",
        groupId: "NA"
      }, {
        title: "Mexico",
        id: "MX",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Guatemala",
        id: "GT",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Cuba",
        id: "CU",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Jamaica",
        id: "JM",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Haiti",
        id: "HT",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Dominican Republic",
        id: "DO",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Bahamas",
        id: "BS",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Belize",
        id: "BZ",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Honduras",
        id: "HN",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "El Salvador",
        id: "SV",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Nicaragua",
        id: "NI",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Costa Rica",
        id: "CR",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Panama",
        id: "PA",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Colombia",
        id: "CO",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Venezuela",
        id: "VE",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Ecuador",
        id: "EC",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Peru",
        id: "PE",
        color: "#2ecc71",
        customData: "LAN",
        groupId: "LAN"
      }, {
        title: "Brazil",
        id: "BR",
        color: "#9b59b6",
        customData: "BR",
        groupId: "BR"
      }, {
        title: "Bolivia",
        id: "BO",
        color: "#34495e",
        customData: "LAS",
        groupId: "LAS"
      }, {
        title: "Chile",
        id: "CL",
        color: "#34495e",
        customData: "LAS",
        groupId: "LAS"
      }, {
        title: "Argentina",
        id: "AR",
        color: "#34495e",
        customData: "LAS",
        groupId: "LAS"
      }, {
        title: "Paraguay",
        id: "PY",
        color: "#34495e",
        customData: "LAS",
        groupId: "LAS"
      }, {
        title: "Uruguay",
        id: "UY",
        color: "#34495e",
        customData: "LAS",
        groupId: "LAS"
      }, {
        title: "Turkey",
        id: "TR",
        color: "#f1c40f",
        customData: "TR",
        groupId: "TR"
      }, {
        title: "Australia",
        id: "AU",
        color: "#95a5a6",
        customData: "OCE",
        groupId: "OCE"
      }, {
        title: "New Zealand",
        id: "NZ",
        color: "#95a5a6",
        customData: "OCE",
        groupId: "OCE"
      }, {
        title: "Russia",
        id: "RU",
        color: "#ecf0f1",
        customData: "RU",
        groupId: "RU"
      }, {
        title: "Kazakhstan",
        id: "KZ",
        color: "#ecf0f1",
        customData: "RU",
        groupId: "RU"
      }, {
        title: "Uzbekistan",
        id: "UZ",
        color: "#ecf0f1",
        customData: "RU",
        groupId: "RU"
      }, {
        title: "Turkmenistan",
        id: "TM",
        color: "#ecf0f1",
        customData: "RU",
        groupId: "RU"
      }, {
        title: "South Korea",
        id: "KR",
        color: "#c0392b",
        customData: "KR",
        groupId: "KR"
      }           
            
    ]
  },

  areasSettings: {
    rollOverOutlineColor: "#FFFFFF",
    rollOverColor: "#CC0000",
    alpha: 0.9,
    unlistedAreasAlpha: 0.1,
    balloonText: "[[title]] - [[customData]]",
    selectable: true
  }

} );

map.addListener("clickMapObject", function (event) {
    
    CURRENT_REGION = event.mapObject.customData.toLowerCase();
    
    updateRegionContent();
});