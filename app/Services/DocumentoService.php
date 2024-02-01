<?php

namespace App\Services;

use App\Models\DocumentoHistorico;
use App\Models\Documentos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use TCPDF;


class DocumentoService
{

    public static function visualizar_documento(Documentos $documentos)
    {
        try {
            if (is_null($documentos->visualizacao)) {
                $documentos->visualizacao = Carbon::now();
                $documentos->update();
            }

            return true;

        } catch (\Exception $e) {
            Log::debug("Erro ao visulizar documento: " . $e);
            throw new \Exception("Erro ao visulizar documento");
        }
    }

    public static function buscarUltimoNumeroTipoDocumento($tipo_documento_id)
    {
        try {

            $result = Documentos::select('numero_documento')->where('tipo_documento_id', $tipo_documento_id)->orderByDesc('id')->limit(1)->first();

            if (!is_null($result)) {
                return $result->numero_documento + 1;
            }
            return 1;

        } catch (\Exception $e) {
            Log::debug("");
        }
    }

    public static function salvarHistorico(
        $titulo, $corpo_texto,
        $descricao, $documento_id, $tipo_documento_id,
        $destinatario_user_id, $data_prazo, $horario_prazo)
    {

        try {
            DocumentoHistorico::create([
                'documento_id' => $documento_id,
                'destinatario_user_id' => $destinatario_user_id,
                'tipo_documento_id' => $tipo_documento_id,
                'corpo_texto' => $corpo_texto,
                'titulo' => $titulo,
                'descricao' => $descricao,
                "data_prazo" => $data_prazo,
                "horario_prazo" => $horario_prazo
            ]);
        } catch (\Exception $e) {
            Log::debug("erro ao salvar historico: " . $e);

        }
    }

    public static function assinarDocumento()
    {
//Endereço do arquivo do certificado
//Obs.: Tentei usar o certificado no formato PFX e não funcionou
//Para converter use o comando no Prompt do Windows ou Terminal do Linux:
//openssl pkcs12 -in certificado.pfx -out tcpdf.crt -nodes
        $certificate = storage_path('app/public/PDG-RootCA.crt');
        $privateKey = storage_path('app/public/PDG-RootCA.pem');
//Informações da assinatura - Preencha com os seus dados
        $info = array(
            'Name' => 'Nome',
            'Location' => 'Localidade',
            'Reason' => 'Descreva o motivo da assinatura',
            'ContactInfo' => 'Dados de contato',
        );
        var_dump($certificate);
        $pdf = new TCPDF();
        //Configura a assinatura. Para saber mais sobre os parâmetros
        //consulte a documentação do TCPDF, exemplo 52.
        //Não esqueça de mudar 'senha' para a senha do seu certificado


        //Importa uma página
        $pdf->AddPage();
        $pdf->WriteHTML('<h1>This is a signed PDF</h1>');
        $pdf->setSignature($certificate, $privateKey, '', '', 2, $info);
        //Manda o PDF pra download
        $pdf->Output('documento_assinado.pdf', storage_path('public/'));
        return true;
    }
}
