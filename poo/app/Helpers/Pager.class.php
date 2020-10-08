<?php

/**
 * Pager.class [ HELPER ]
 * PAGINA RESPONSAVEL PELA PAGINAÇÃO DO SITE
 * @copyright (c) 2014, Fabio Augusto CASA DOS SITES
 * 
 * COMO FUNCIONA ****************
 * *****************************
    $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
    $Pager = new Pager('02-novos_projetos_poo/atual=', 'Primeira', 'Última', '1');
    $Pager->ExePager($atual, 1);

    $read = new Read;
    $read->ExeRead('ws_categories', 'LIMIT :limit OFFSET :offset', "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");


   if(!$read->getRowCount()):
        $Pager->ReturnPage();
        echo 'Não existe resultados! <hr>';
    else:
        var_dump($read->getResult());
    endif;

    echo '<hr>';

    $Pager->ExePaginator('ws_categories');
    echo $Pager->getPaginator();
 */
class Pager {

    /** DEFINE O PAGER */
    private $Page;
    private $Limit;
    private $Offset;

    /** REALIZA A LEITURA */
    private $Tabela;
    private $Termos;
    private $Places;

    /** DEFINE O PAGINATOR */
    private $Rows;
    private $Links;
    private $MaxLinks;
    private $First;
    private $Last;

    /** RENDEREZA O PAGINATOR */
    Private $Paginator;

    function __construct($Links, $First = null, $Last = null, $MaxLinks = null) {
        $this->Links = (string) $Links;
        $this->First = ((string) $First ? $First : 'Primeita Página');
        $this->Last = ((string) $Last ? $Last : 'Última Página');
        $this->MaxLinks = ( (int) $MaxLinks ? $MaxLinks : 5);
    }

    public function ExePager($Page, $Limit) {
        $this->Page = ((int) $Page ? $Page : 1);
        $this->Limit = (int) $Limit;
        $this->Offset = ($this->Page * $this->Limit) - $this->Limit;
    }

    public function ReturnPage() {
        if ($this->Page > 1):
            $nPage = $this->Page - 1;
            header("location: {$this->Links}{$nPage}");
        endif;
    }

    function getPage() {
        return $this->Page;
    }

    function getLimit() {
        return $this->Limit;
    }

    function getOffset() {
        return $this->Offset;
    }

    public function ExePaginator($Tabela, $Termos = null, $ParseString = null) {
        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;
        $this->Places = (string) $ParseString;
        $this->getSyntax();
    }

    public function getPaginator() {
        return $this->Paginator;
    }

    //FUNÇÕES PRIVADAS

    private function getSyntax() {
        $read = new Read;
        $read->ExeRead($this->Tabela, $this->Termos, $this->Places);
        $this->Rows = $read->getRowCount();

        if ($this->Rows > $this->Limit):
            $Paginas = ceil($this->Rows / $this->Limit);
            $MaxLinks = $this->MaxLinks;

            $this->Paginator = "<ul class=\"paginator\">"; // atacar o css na class paginator
            $this->Paginator .= "<li><a title=\"{$this->First}\" href=\"{$this->Links}1\">{$this->First}</a></li>";

            for ($ipag = $this->Page - $MaxLinks; $ipag <= $this->Page - 1; $ipag ++):
                if ($ipag >= 1):
                    $this->Paginator .= "<li><a title=\"Página{$ipag}\" href=\"{$this->Links}{$ipag}\">{$ipag}</a></li>";
                endif;
            endfor;

            $this->Paginator .= "<li><span class=\"active\">{$this->Page}</span></li>";

            for ($dpag = $this->Page + 1; $dpag <= $this->Page + 1; $dpag ++):
                if ($dpag <= $Paginas):
                    $this->Paginator .= "<li><a title=\"Página{$dpag}\" href=\"{$this->Links}{$dpag}\">{$dpag}</a></li>";
                endif;
            endfor;

            $this->Paginator .= "<li><a title=\"{$this->Last}\" href=\"{$this->Links}{$Paginas}\">{$this->Last}</a></li>";
            $this->Paginator .= "</ul>";
        endif;
    }

}
