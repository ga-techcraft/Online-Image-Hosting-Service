<?php

namespace Routing;

use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;
use Response\Render\BinaryRenderer;

use Database\DataAccess\Implementions\ImagesDAOImpl;
use Models\Images;

return [
  '' => function (): HTMLRenderer {
    return new HTMLRenderer('file_upload', []);
  },
  // 画像アップロード
  'api/images/upload' => function (): JSONRenderer {
    // 画像のバリデーション
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    
    if (!in_array($fileExtension, $allowedExtensions)) {
      return new JSONRenderer([
        'error' => 'Invalid file type',
      ]);
    }

    // 画像の保存（ストレージ）
    $image = $_FILES['image'];
    $uniqueString = bin2hex(random_bytes(16));
    $filePath = __DIR__ . '/../storage/images/' . $uniqueString;
    file_put_contents($filePath, file_get_contents($image['tmp_name']));

    // 画像のパスの保存（DB）
    $images = new Images($image['name'], $uniqueString);
    $ImageDAOImpl = new ImagesDAOImpl();
    $ImageDAOImpl->create($images);

    return new JSONRenderer([
      'uniqueString' => $uniqueString,
    ]);

  },
  // 画像本体データを返す
  'api/images/view' => function (): BinaryRenderer {
    $uniqueString = $_GET['uniqueString'];
    $binaryPath = __DIR__ . '/../storage/images/' . $uniqueString;
    $mimeType = mime_content_type($binaryPath);
    return new BinaryRenderer($mimeType, $uniqueString);
  },
  // 画像の削除
  'api/images/delete' => function (): HTMLRenderer {
    $uniqueString = $_GET['uniqueString'];

    // DBに指定された画像が存在するか確認
    $ImageDAOImpl = new ImagesDAOImpl();
    $image = $ImageDAOImpl->getByUniqueString($uniqueString);
    
    if($image === null){
      return new HTMLRenderer('result', [
        'result' => 'Image not found',
      ]);
    } else {
      // DBから画像を削除
      $ImageDAOImpl->delete($image->getId());

      // 画像ファイルをディレクトリから削除
      unlink(__DIR__ . '/../storage/images/' . $uniqueString);

      return new HTMLRenderer('result', [
        'result' => 'Image deleted',
      ]);
    }
  },
];