<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DOMDocument;

class TesteController extends BaseController
{
    // Método para exibir a página web - home
    public function index()
    {
        $data = $this->getData();

        return view('home', compact('data'));
    }

    // Método para retornar um json no endpoint
    public function indexApi()
    {
        $data = $this->getData();

        return response()->json($data);
    }

    private function getData()
    {
        $url = "http://www.guiatrabalhista.com.br/guia/salario_minimo.htm";

        // Client guzzle para download da página
        $request = $this->getClient()->get($url);

        // DOMDocument para criar um objeto com base no html requisitado
        $dom = new DOMDocument;
        @$dom->loadHTML($this->getResult($request));

        // Pesquisa o documento baseado nas tags html
        $table = $dom->getElementsByTagName("table")[0];
        $rows = $table->getElementsByTagName("tr");

        // Para criar a key do array baseado no cabeçalho da tabela
        $header = array();

        // Neste array ficará armazenado toda a tabela
        $alldata = array();

        // Loop para leitura do documento
        // Loop nas linhas <tr>
        foreach($rows as $keyrow => $row) {
            $cells = $row->getElementsByTagName("td");
            
            // Objeto para guardar a linha
            $obj = array();
            // Loop nas celulas da linha atual <td>
            foreach($cells as $keycell => $cell) {
                // Se for 0 é cabeçalho, assim ele cria o array base para o nome das keys do array
                if($keyrow == 0) {
                    array_push($header, $this->formatHeader(trim($cell->nodeValue)));
                } else {
                    $obj[$header[$keycell]] = trim($cell->nodeValue);
                }
            }

            // Adiciona a linha ao objeto $alldata que vai guardar toda a tabela
            if($keyrow > 0) array_push($alldata, $obj);
        }

        // Retorno da função com a tabela transformada em array
        return $alldata;
    }

}
