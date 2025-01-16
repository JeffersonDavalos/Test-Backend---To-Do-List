<?php

namespace App\Http\Controllers;

use App\Services\UsuarioService;
use Illuminate\Routing\Controller; 
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class UsuarioController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     *
     * @param Request 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {

            $usuario = $request->input('usuario');
            $cedula = $request->input('cedula');

            $resultado = $this->usuarioService->obtenerContraseñaPorUsuarioYCedula($usuario, $cedula);
            if (isset($resultado['error'])) {
                return response()->json(['error' => $resultado['error']], 500);
            }

            return response()->json($resultado, 200);

        } catch (Exception $e) {
            Log::error('Error al obtener usuarios: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }
    public function registrarUsuario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $resultado = $this->usuarioService->registrarUsuario($data);
            return $resultado;
        } catch (Exception $e) {
            Log::error('Error en el controlador al registrar usuario: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actualizarUsuario(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $resultado = $this->usuarioService->actualizarUsuario($data);
            return $resultado;
        } catch (Exception $e) {
            Log::error('Error en el controlador al registrar usuario: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }
    public function actualizarEstado(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $resultado = $this->usuarioService->actualizarEstado($data);
            return $resultado;
        } catch (Exception $e) {
            Log::error('Error en el controlador al actualizar estado: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }
    public function eliminarTarea($id_tarea): JsonResponse
    {
        try {
            $resultado = $this->usuarioService->eliminartarea($id_tarea);
            return $resultado;
        } catch (Exception $e) {
            Log::error('Error en el controlador al eliminar tarea: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }
    public function obtenermaterias(): JsonResponse
    {
        try {
            $resultado = $this->usuarioService->obtenerTodasLasMaterias();
            return $resultado;
        } catch (Exception $e) {
            Log::error('Error en el controlador al obtenermaterias: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }
    public function registrartarea(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $resultado = $this->usuarioService->registrarTarea($data);
            return $resultado;
        } catch (Exception $e) {
            Log::error('Error en el controlador registrartarea: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }
    public function reporTarea(Request $request): JsonResponse
    {
        try {
            $tarea = $request->input('titulo');
            $materia = $request->input('materia');
            $estado = $request->input('estado');
            $fechaInicio = $request->input('fechaInicio');
            $fechaFin = $request->input('fechaFin');
            $resultado = $this->usuarioService->reporTareas($tarea, $materia,$estado ,$fechaInicio, $fechaFin);
            if (isset($resultado['error'])) {
                return response()->json(['error' => $resultado['error']], 500);
            }
            return response()->json($resultado, 200);
    
        } catch (Exception $e) {
            Log::error('Error al obtener reporTarea: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }
    public function obtenerestado(): JsonResponse
    {
        try {
            $resultado = $this->usuarioService->obtenerestados();
            return $resultado;
        } catch (Exception $e) {
            Log::error('Error en el controlador  obtenerestado ' . $e->getMessage());
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }
}
