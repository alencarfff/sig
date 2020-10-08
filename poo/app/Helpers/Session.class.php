<?php

/**
 * Session [ HELPER ]
 * RESPONSÁVEL POR GERENCIAR A AS SESSÕES E ESTATITICAS DO NOSSO WEB SITE.
 * @copyright (c) 2014, Fabio Augusto CASA DOS SITES
 */
class Session {

    private $Date;
    private $Cache;
    private $Traffic;
    private $Browser;

    function __construct($Cache = NULL) {
        session_start();
        $this->CheckSession($Cache);
    }

    //verificar a execução de todos os metodos da class
    private function CheckSession($Cache = null) {
        $this->Date = date('Y-m-d');
        $this->Cache = ( (int) $Cache ? $Cache : 20);

        if (empty($_SESSION['useronline'])):
            $this->setTraffic();
            $this->setSession();
            $this->CheckBrowser();
            $this->setUsuario();
            $this->BrowserUpdate();
        else:
            $this->TrafficUpdate();
            $this->sessionUpdate();
            $this->CheckBrowser();
            $this->UsuarioUpdate();
        endif;

        $this->Date = null;
    }

    //inicia a sessão do usuário
    private function setSession() {
        $_SESSION['useronline'] = [
            "online_session" => session_id(),
            "online_startview" => date('Y-m-d H:i:s'),
            "online_endview" => date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes")),
            "online_ip" => $_SERVER['REMOTE_ADDR'],
            "online_url" => $_SERVER['REQUEST_URI'],
            "online_agent" => strip_tags(trim($_SERVER['HTTP_USER_AGENT']))
//            "online_ip" => filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP),
//            "online_url" => filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT),
//            "online_agent" => filter_input(INPUT_SERVER, "HTTP_USER_AGENT", FILTER_DEFAULT)
        ];
    }

    //atualiza sess~ao do usuario
    private function sessionUpdate() {
        $_SESSION['useronline']['online_endview'] = date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes"));
        $_SESSION['useronline']['online_url'] = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
    }

    //verifica e insere o tráfico na tabela
    private function setTraffic() {
        $this->getTraffic();
        if (!$this->Traffic):
            $ArrSiteViews = [
                'siteviews_date' => $this->Date,
                'siteviews_users' => 1,
                'siteviews_views' => 1,
                'siteviews_pages' => 1
            ];
            $createSiteViews = new Create;
            $createSiteViews->ExeCreate('ws_siteviews', $ArrSiteViews);
        else:
            if (!$this->getCookie()):
                $ArrSiteViews = [
                    'siteviews_users' => $this->Traffic['siteviews_users'] + 1,
                    'siteviews_views' => $this->Traffic['siteviews_views'] + 1,
                    'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1
                ];
            else:
                $ArrSiteViews = [
                    'siteviews_views' => $this->Traffic['siteviews_views'] + 1,
                    'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1
                ];
            endif;

            $updateSiteViews = new Update;
            $updateSiteViews->ExeUpdate('ws_siteviews', $ArrSiteViews, "WHERE siteviews_date=:date", "date={$this->Date}");

        endif;
    }

    //verifica e atualiza os pagewies
    private function TrafficUpdate() {
        $this->getTraffic();
        $ArrSiteViews = [
            'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1,
        ];
        $updatePageViews = new Update;
        $updatePageViews->ExeUpdate('ws_siteviews', $ArrSiteViews, "WHERE siteviews_date=:date", "date={$this->Date}");

        $this->Traffic = null;
    }

    private function getTraffic() {
        $readSiteViews = new Read;
        $readSiteViews->ExeRead('ws_siteviews', "WHERE siteviews_date = :date", "date={$this->Date}");
        if ($readSiteViews->getRowCount()):
            $this->Traffic = $readSiteViews->getResult()[0];
        endif;
    }

    //verifica, cria e atualiza o cookie do usuario [HELPER TRAFFIC]
    private function getCookie() {
        $Cookie = filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);
        setcookie("useronline", base64_encode("casadossites"), time() + 86400);
        if (!$Cookie):
            return false;
        else:
            return true;
        endif;
    }

    //identicda o navegador do usuario
    private function CheckBrowser() {
        $this->Browser = $_SESSION['useronline']['online_agent'];
        if (strpos($this->Browser, 'Chrome')):
            $this->Browser = 'Chrome';
        elseif (strpos($this->Browser, 'Firefox')):
            $this->Browser = 'Firefox';
        elseif (strpos($this->Browser, 'MSIE') || strpos($this->Browser, 'Trident/')):
            $this->Browser = 'IE';
        else:
            $this->Browser = 'Outros';
        endif;
    }

    //atualiza a tabela com dados dos navegadores
    private function BrowserUpdate() {
        $readAgent = new Read;
        $readAgent->ExeRead('ws_siteviews_agent', "WHERE agent_name = :agent", "agent={$this->Browser}");
        if (!$readAgent->getResult()):
            $ArrAgent = ['agent_name' => $this->Browser, 'agent_views' => 1];
            $createAgent = new Create;
            $createAgent->ExeCreate('ws_siteviews_agent', $ArrAgent);
        else:
            $ArrAgent = ['agent_views' => $readAgent->getResult()[0]['agent_views'] + 1];
            $updateAgent = new Update;
            $updateAgent->ExeUpdate('ws_siteviews_agent', $ArrAgent, "WHERE agent_name = :name", "name={$this->Browser}");
        endif;
    }

    //usuarios online
    //cadastra usuario na tabela
    private function setUsuario() {
        $sesOnline = $_SESSION['useronline'];
        $sesOnline['online_agent'] = $this->Browser;

        $userCreate = new Create;
        $userCreate->ExeCreate('ws_siteviews_online', $sesOnline);
    }

    // atualiza a navegação do usuario
    private function UsuarioUpdate() {
        $ArrOnlone = [
            'online_endview' => $_SESSION['useronline']['online_endview'],
            'online_url' => $_SESSION['useronline']['online_url']
        ];

        $userUpdate = new Update;
        $userUpdate->ExeUpdate('ws_siteviews_online', $ArrOnlone, "WHERE online_session = :ses", "ses={$_SESSION['useronline']['online_session']}");

        if (!$userUpdate->getRowCount()):
            $readSes = new Read;
            $readSes->ExeRead('ws_siteviews_online', "WHERE online_session = :onses", "onses={$_SESSION['useronline']['online_session']}");
            if (!$readSes->getRowCount()):
                $this->setUsuario();
            endif;
        endif;
    }

}
