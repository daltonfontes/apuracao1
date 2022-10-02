<?php

$url = 'https://resultados.tse.jus.br/oficial/ele2022/544/dados-simplificados/br/br-c0001-e000544-r.json';

$encode = json_decode(file_get_contents($url), true);
$informacoes = [];

$data = (['Secoes Totalizadas' => $encode['psi']]);
$att = (['Ultima Atualizacao' => $encode['ht']]);
$ntt = (['Não totalizadas' => $encode['snt']]);
$nulos = (['Votos Nulos' => $encode['tvn']]);


foreach ($encode['cand'] as $candidatos) {
    $informacoes[$candidatos['n']] = [
        'Partido' => $candidatos['n'],
        'Candidato' => $candidatos['nm'],
        'Votos Apurados' => $candidatos['vap'],
        'Percentual Apurados' => $candidatos['pvap']
    ];
}
$filter = array_filter($informacoes, function ($value) {
    return $value['Partido'] == '13' || $value['Partido'] == '22';
});
$informacoes = array_merge($data, $att, $ntt, $filter, $nulos);
header('Content-Type: application/json');
echo json_encode($informacoes, JSON_PRETTY_PRINT);
