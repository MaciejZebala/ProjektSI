<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerGWohqqI\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerGWohqqI/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerGWohqqI.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerGWohqqI\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerGWohqqI\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'GWohqqI',
    'container.build_id' => 'f0f04909',
    'container.build_time' => 1590846000,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerGWohqqI');
