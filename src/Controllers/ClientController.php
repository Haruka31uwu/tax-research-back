<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ClientController extends BaseController
{
    public function insert($request, $response, $args)
    {

        try {
            $data = $request->getParsedBody();
            $pdo = $this->container->get('db');
            $sql = "CALL sp_insert_update_client(:id,:nombre, :apellido, :edad, :fecnac, :dni)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':apellido', $data['apellido']);
            $stmt->bindParam(':edad', $data['edad']);
            $stmt->bindParam(':fecnac', $data['fecnac']);
            $stmt->bindParam(':dni', $data['dni']);
            $stmt->execute();
            $response->getBody()->write(
                json_encode([
                    'message' => 'Client inserted successfully'
                ])
            );
            return $response->withHeader('content-type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode($e->getMessage()));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
    public function update($request, $response, $args)
    {
        try {
            $data = $request->getParsedBody();
            $pdo = $this->container->get('db');
            $sql = "CALL sp_insert_update_client(:id,:nombre, :apellido, :edad, :fecnac, :dni)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', intval($data['id']));
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':apellido', $data['apellido']);
            $stmt->bindParam(':edad', $data['edad']);
            $stmt->bindParam(':fecnac', $data['fecnac']);
            $stmt->bindParam(':dni', $data['dni']);
            $stmt->execute();
            $response->getBody()->write(
                json_encode([
                    'message' => 'Client updated successfully'
                ])
            );
            return $response->withHeader('content-type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode($e->getMessage()));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
    public function delete($request, $response, $args)
    {
        try {
            $data = $request->getParsedBody();
            $pdo = $this->container->get('db');
            $sql = "CALL sp_delete_client(:id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $data['id']);
            $stmt->execute();
            $response->getBody()->write(
                json_encode([
                    'message' => 'Client deleted successfully'
                ])
            );
            return $response->withHeader('content-type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode($e->getMessage()));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
    public function getAll($request, $response, $args)
    {
        try {
            $page = $request->getParsedBody()['page'] ?? 1;
            $pageSize = $request->getParsedBody()['pageSize'] ?? 10;
            $offset = ($page - 1) * $pageSize;
            $pdo = $this->container->get('db');
            $stmt = $pdo->prepare("CALL sp_get_all_clients(:offset, :pageSize)");
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->bindParam(':pageSize', $pageSize, \PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll();
            $stmt->closeCursor(); // Cerrar el cursor para liberar la conexión

            // Obtener el total de elementos y calcular el total de páginas
            $totalElements = $pdo->query("SELECT id from clients")->rowCount();
            $totalPages = ceil($totalElements / $pageSize);
            $response->getBody()->write(json_encode([
                'totalElements' => $totalElements,
                "from" => $offset==0?1:$offset,
                "to" => $offset+$pageSize<=$totalElements?$offset+$pageSize:$totalElements,      
                'currentPage' => $page,
                'pageSize' => $pageSize,
                'totalPages' => $totalPages,
                'data' => $data
            ]));
            return $response->withHeader('content-type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode($e->getMessage()));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
}
