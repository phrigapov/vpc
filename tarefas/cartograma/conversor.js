var converterEstados = function (val) {
    var data;

    switch (val.toUpperCase()) {
        /* UFs */
        case "AC": data = "ACRE"; break;
        case "AL": data = "ALAGOAS"; break;
        case "AM": data = "AMAZONAS"; break;
        case "AP": data = "AMAPÁ"; break;
        case "BA": data = "BAHIA"; break;
        case "CE": data = "CEARÁ"; break;
        case "DF": data = "DISTRITO FEDERAL"; break;
        case "ES": data = "ESPÍRITO SANTO"; break;
        case "GO": data = "GOIÁS"; break;
        case "MA": data = "MARANHÃO"; break;
        case "MG": data = "MINAS GERAIS"; break;
        case "MS": data = "MATO GROSSO DO SUL"; break;
        case "MT": data = "MATO GROSSO"; break;
        case "PA": data = "PARÁ"; break;
        case "PB": data = "PARAÍBA"; break;
        case "PE": data = "PERNAMBUCO"; break;
        case "PI": data = "PIAUÍ"; break;
        case "PR": data = "PARANÁ"; break;
        case "RJ": data = "RIO DE JANEIRO"; break;
        case "RN": data = "RIO GRANDE DO NORTE"; break;
        case "RO": data = "RONDÔNIA"; break;
        case "RR": data = "RORAIMA"; break;
        case "RS": data = "RIO GRANDE DO SUL"; break;
        case "SC": data = "SANTA CATARINA"; break;
        case "SE": data = "SERGIPE"; break;
        case "SP": data = "SÃO PAULO"; break;
        case "TO": data = "TOCANTÍNS"; break;

        /* Estados */
        case "ACRE": data = "AC"; break;
        case "ALAGOAS": data = "AL"; break;
        case "AMAZONAS": data = "AM"; break;
        case "AMAPÁ": data = "AP"; break;
        case "BAHIA": data = "BA"; break;
        case "CEARÁ": data = "CE"; break;
        case "DISTRITO FEDERAL": data = "DF"; break;
        case "ESPÍRITO SANTO": data = "ES"; break;
        case "GOIÁS": data = "GO"; break;
        case "MARANHÃO": data = "MA"; break;
        case "MINAS GERAIS": data = "MG"; break;
        case "MATO GROSSO DO SUL": data = "MS"; break;
        case "MATO GROSSO": data = "MT"; break;
        case "PARÁ": data = "PA"; break;
        case "PARAÍBA": data = "PB"; break;
        case "PERNAMBUCO": data = "PE"; break;
        case "PIAUÍ": data = "PI"; break;
        case "PARANÁ": data = "PR"; break;
        case "RIO DE JANEIRO": data = "RJ"; break;
        case "RIO GRANDE DO NORTE": data = "RN"; break;
        case "RONDÔNIA": data = "RO"; break;
        case "RORAIMA": data = "RR"; break;
        case "RIO GRANDE DO SUL": data = "RS"; break;
        case "SANTA CATARINA": data = "SC"; break;
        case "SERGIPE": data = "SE"; break;
        case "SÃO PAULO": data = "SP"; break;
        case "TOCANTÍNS": data = "TO"; break;
    }

    return data;
};